<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationAnswer;
use App\Models\ConsultationImage;
use App\Models\Device;
use App\Models\Symptom;
use App\Services\DeviceRecognitionService;
use App\Services\ExpertSystemService;
use App\Services\ImageAnalysisService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    public function __construct(
        private ExpertSystemService $expertSystem,
        private ImageAnalysisService $imageAnalysis,
        private DeviceRecognitionService $deviceRecognition,
    ) {}

    public function index()
    {
        $consultations = auth()->user()->consultations()
            ->with('device.category', 'diagnosis')
            ->latest()
            ->paginate(10);

        return view('user.consultation.index', compact('consultations'));
    }

    public function create()
    {
        $devices = Device::orderBy('name')->get(['id', 'name']);

        return view('user.consultation.create', compact('devices'));
    }

    /**
     * Users only upload photos and describe the problem. The device is
     * recognised by the AI from the photos, or from the complaint text when
     * AI analysis is unavailable.
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'initial_complaint' => ['required', 'string', 'max:1000'],
            'images' => ['required', 'array', 'min:1', 'max:5'],
            'images.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        foreach ($request->file('images') as $image) {
            $errors = $this->imageAnalysis->validateImage($image);
            if ($errors !== []) {
                return back()->withErrors(['images' => $errors[0]])->withInput();
            }
        }

        $imagePaths = array_map(
            fn ($image) => $this->imageAnalysis->storeImage($image),
            $request->file('images'),
        );

        $visualEvidence = $this->imageAnalysis->analyzeUpload($imagePaths, $request->initial_complaint);
        $device = Device::find($visualEvidence['device_id'] ?? null)
            ?? $this->deviceRecognition->recognizeFromText($request->initial_complaint);

        if ($device === null) {
            array_map(fn (string $path) => $this->imageAnalysis->deleteImage($path), $imagePaths);

            return back()
                ->withErrors(['initial_complaint' => $this->unrecognizedDeviceMessage($visualEvidence['device_label'] ?? '')])
                ->withInput();
        }

        $consultation = Consultation::create([
            'user_id' => $request->user()?->isUser() ? $request->user()->id : null,
            'device_id' => $device->id,
            'consultation_code' => 'CONS-'.strtoupper(Str::random(8)),
            'device_brand' => $visualEvidence['device_brand'] ?? null,
            'device_model' => $visualEvidence['device_model'] ?? null,
            'initial_complaint' => $request->initial_complaint,
            'status' => 'in_progress',
            'visual_evidence' => $visualEvidence,
        ]);

        if ($consultation->isGuest()) {
            $request->session()->push(Consultation::GUEST_SESSION_KEY, $consultation->id);
        }

        foreach ($imagePaths as $path) {
            ConsultationImage::create([
                'consultation_id' => $consultation->id,
                'image_path' => $path,
                'created_at' => now(),
            ]);
        }

        $this->recordAutomaticAnswers($consultation);

        return $this->continueDiagnosis($consultation);
    }

    /**
     * Adaptive questioning: shows one question at a time, or the question the
     * user asked to change (?ubah={symptom_id}).
     */
    public function questions(Request $request, Consultation $consultation)
    {
        $this->authorizeConsultation('view', $consultation);

        $answers = $this->knownAnswers($consultation);
        $plan = $this->expertSystem->questionPlan($consultation->device_id, $answers);

        $editing = $request->filled('ubah')
            ? Symptom::where('device_id', $consultation->device_id)->find($request->integer('ubah'))
            : null;
        $question = $editing ?? $plan['next'];

        if ($question === null) {
            if ($consultation->status === 'in_progress') {
                $this->concludeDiagnosis($consultation);
            }

            return redirect()->route('diagnosis.result', $consultation);
        }

        $knownAnswers = $consultation->answers()->with('symptom')->orderBy('id')->get();
        $askedCount = $knownAnswers->where('source', ConsultationAnswer::SOURCE_USER)->count();

        return view('user.consultation.questions', [
            'consultation' => $consultation->load('device'),
            'question' => $question,
            'currentAnswer' => $answers[$question->id] ?? null,
            'knownAnswers' => $knownAnswers,
            'askedCount' => $askedCount,
            'remainingCount' => $editing ? $plan['remaining'] : max(0, $plan['remaining'] - 1),
            'isEditing' => $editing !== null,
        ]);
    }

    /**
     * Stores one answer (symptom_id + answer) or several (symptom_{id} fields),
     * then asks the next question or concludes the diagnosis.
     */
    public function processAnswers(Request $request, Consultation $consultation)
    {
        $this->authorizeConsultation('update', $consultation);

        $deviceSymptomIds = Symptom::where('device_id', $consultation->device_id)->pluck('id');
        $submitted = [];

        if ($request->has('symptom_id')) {
            $validated = $request->validate([
                'symptom_id' => ['required', 'integer', 'in:'.$deviceSymptomIds->implode(',')],
                'answer' => ['required', 'boolean'],
            ]);
            $submitted[(int) $validated['symptom_id']] = (bool) $validated['answer'];
        } else {
            foreach ($deviceSymptomIds as $symptomId) {
                if ($request->has('symptom_'.$symptomId)) {
                    $submitted[$symptomId] = $request->boolean('symptom_'.$symptomId);
                }
            }
        }

        foreach ($submitted as $symptomId => $answer) {
            ConsultationAnswer::updateOrCreate(
                ['consultation_id' => $consultation->id, 'symptom_id' => $symptomId],
                ['answer' => $answer, 'source' => ConsultationAnswer::SOURCE_USER, 'created_at' => now()]
            );
        }

        return $this->continueDiagnosis($consultation);
    }

    /**
     * Answers questions the user already answered in their complaint, and
     * those the AI could see clearly in the photos.
     */
    private function recordAutomaticAnswers(Consultation $consultation): void
    {
        $fromComplaint = $this->expertSystem->answersFromComplaint($consultation->device_id, $consultation->initial_complaint);
        $fromPhotos = array_diff_key($this->expertSystem->answersFromPhotos($consultation->visual_evidence), $fromComplaint);

        foreach ([ConsultationAnswer::SOURCE_COMPLAINT => $fromComplaint, ConsultationAnswer::SOURCE_PHOTO => $fromPhotos] as $source => $answers) {
            foreach ($answers as $symptomId => $answer) {
                ConsultationAnswer::create([
                    'consultation_id' => $consultation->id,
                    'symptom_id' => $symptomId,
                    'answer' => $answer,
                    'source' => $source,
                    'created_at' => now(),
                ]);
            }
        }
    }

    private function continueDiagnosis(Consultation $consultation)
    {
        $plan = $this->expertSystem->questionPlan($consultation->device_id, $this->knownAnswers($consultation));

        if ($plan['next'] === null) {
            $this->concludeDiagnosis($consultation);

            return redirect()->route('diagnosis.result', $consultation);
        }

        $consultation->update(['status' => 'in_progress']);

        return redirect()->route('diagnosis.questions', $consultation);
    }

    /**
     * @return array<int, bool> symptom_id => answer
     */
    private function knownAnswers(Consultation $consultation): array
    {
        return $consultation->answers()->pluck('answer', 'symptom_id')->map(fn ($answer) => (bool) $answer)->all();
    }

    private function concludeDiagnosis(Consultation $consultation): void
    {
        $photoAnswered = $consultation->answers()->where('source', ConsultationAnswer::SOURCE_PHOTO)->pluck('symptom_id')->all();

        $results = $this->expertSystem->processAnswers(
            $consultation->device_id,
            $this->knownAnswers($consultation),
            $consultation->visual_evidence,
            $photoAnswered,
        );
        $primary = $this->expertSystem->determineDiagnosis($results);

        if ($primary && $primary['confidence'] >= 40) {
            $consultation->update([
                'diagnosis_id' => $primary['diagnosis']->id,
                'confidence' => $primary['confidence'],
                'all_diagnoses' => array_map(fn ($r) => [
                    'diagnosis_id' => $r['diagnosis']->id,
                    'name' => $r['diagnosis']->name,
                    'confidence' => $r['confidence'],
                    ...array_intersect_key($r, array_flip(['base_confidence', 'visual_support'])),
                ], $results),
                'status' => 'completed',
            ]);
        } else {
            $consultation->update([
                'diagnosis_id' => null,
                'confidence' => null,
                'all_diagnoses' => null,
                'status' => 'no_diagnosis',
            ]);
        }
    }

    public function result(Consultation $consultation)
    {
        $this->authorizeConsultation('view', $consultation);

        if ($consultation->status === 'in_progress') {
            return redirect()->route('diagnosis.questions', $consultation);
        }

        $consultation->load('device.category', 'diagnosis.repairGuides', 'diagnosis.solutions', 'images', 'answers.symptom');

        $repairability = null;
        if ($consultation->diagnosis) {
            $repairability = $this->expertSystem->getRepairability($consultation->diagnosis);
        }

        return view('user.consultation.result', compact('consultation', 'repairability'));
    }

    public function history()
    {
        $consultations = auth()->user()->consultations()
            ->with('device', 'diagnosis', 'booking')
            ->latest()
            ->paginate(15);

        return view('user.history', compact('consultations'));
    }

    /**
     * Tells the user what to add to the complaint, or that the device the AI
     * saw is not covered by the knowledge base yet.
     */
    private function unrecognizedDeviceMessage(string $detectedLabel): string
    {
        if ($detectedLabel !== '') {
            return "Perangkat Anda terlihat seperti {$detectedLabel}, yang belum bisa didiagnosis otomatis oleh FIXMATE. Silakan cari teknisi untuk pemeriksaan langsung.";
        }

        $supported = Device::orderBy('name')->pluck('name')->implode(', ');

        return "Kami belum bisa mengenali perangkatnya. Sebutkan jenis perangkat di keluhan Anda, misalnya \"HP saya layarnya retak\". Perangkat yang didukung: {$supported}.";
    }

    /**
     * Visitors opening a saved consultation are asked to sign in first and
     * are brought back to it afterwards.
     */
    private function authorizeConsultation(string $ability, Consultation $consultation): void
    {
        if (! $consultation->isGuest() && auth()->guest()) {
            throw new AuthenticationException;
        }

        $this->authorize($ability, $consultation);
    }
}
