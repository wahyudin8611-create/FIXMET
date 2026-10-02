<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Consultation;
use App\Models\ConsultationAnswer;
use App\Models\ConsultationImage;
use App\Models\Symptom;
use App\Services\ExpertSystemService;
use App\Services\ImageAnalysisService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function __construct(
        private ExpertSystemService $expertSystem,
        private ImageAnalysisService $imageAnalysis,
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
        $categories = Category::with('devices')->get();

        return view('user.consultation.create', compact('categories'));
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'device_id' => ['required', Rule::exists('devices', 'id')->where('category_id', $request->integer('category_id'))],
            'device_brand' => ['nullable', 'string', 'max:100'],
            'device_model' => ['nullable', 'string', 'max:100'],
            'device_age' => ['nullable', 'integer', 'min:0', 'max:50'],
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

        $consultation = Consultation::create([
            'user_id' => $request->user()?->isUser() ? $request->user()->id : null,
            'device_id' => $request->device_id,
            'consultation_code' => 'CONS-'.strtoupper(Str::random(8)),
            'device_brand' => $request->device_brand,
            'device_model' => $request->device_model,
            'device_age' => $request->device_age,
            'initial_complaint' => $request->initial_complaint,
            'status' => 'in_progress',
        ]);

        if ($consultation->isGuest()) {
            $request->session()->push(Consultation::GUEST_SESSION_KEY, $consultation->id);
        }

        foreach ($request->file('images') as $image) {
            $path = $this->imageAnalysis->storeImage($image);
            ConsultationImage::create([
                'consultation_id' => $consultation->id,
                'image_path' => $path,
                'created_at' => now(),
            ]);
        }

        $visualEvidence = $this->imageAnalysis->analyzeConsultation($consultation);
        if ($visualEvidence !== null) {
            $consultation->update(['visual_evidence' => $visualEvidence]);
        }

        return redirect()->route('diagnosis.questions', $consultation);
    }

    public function questions(Consultation $consultation)
    {
        $this->authorizeConsultation('view', $consultation);

        $symptoms = Symptom::where('device_id', $consultation->device_id)->get();

        return view('user.consultation.questions', compact('consultation', 'symptoms'));
    }

    public function processAnswers(Request $request, Consultation $consultation)
    {
        $this->authorizeConsultation('update', $consultation);

        $symptoms = Symptom::where('device_id', $consultation->device_id)->get();

        $answers = [];
        foreach ($symptoms as $symptom) {
            $key = 'symptom_'.$symptom->id;
            $answer = $request->has($key) ? (bool) $request->$key : false;
            $answers[$symptom->id] = $answer;

            ConsultationAnswer::updateOrCreate(
                ['consultation_id' => $consultation->id, 'symptom_id' => $symptom->id],
                ['answer' => $answer, 'created_at' => now()]
            );
        }

        // Run Expert System
        $results = $this->expertSystem->processAnswers($consultation->device_id, $answers, $consultation->visual_evidence);
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

        return redirect()->route('diagnosis.result', $consultation);
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
