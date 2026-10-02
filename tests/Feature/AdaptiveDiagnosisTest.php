<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\ConsultationAnswer;
use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\Rule;
use App\Models\RuleSymptom;
use App\Models\Symptom;
use App\Services\ClaudeVisionClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Mockery\MockInterface;
use Tests\TestCase;

class AdaptiveDiagnosisTest extends TestCase
{
    use RefreshDatabase;

    private Device $laptop;

    private Symptom $hot;

    private Symptom $noisyFan;

    private Symptom $stripedScreen;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $category = Category::create(['name' => 'Laptop & Komputer']);
        $this->laptop = Device::create(['category_id' => $category->id, 'name' => 'Laptop', 'keywords' => 'laptop']);

        $this->hot = Symptom::create(['device_id' => $this->laptop->id, 'code' => 'L002', 'question' => 'Apakah laptop terasa sangat panas?', 'keywords' => 'panas, kepanasan']);
        $this->noisyFan = Symptom::create(['device_id' => $this->laptop->id, 'code' => 'L006', 'question' => 'Apakah kipas laptop berbunyi berisik?', 'keywords' => 'kipas berisik']);
        $this->stripedScreen = Symptom::create(['device_id' => $this->laptop->id, 'code' => 'L004', 'question' => 'Apakah layar menampilkan garis-garis?', 'keywords' => 'bergaris']);

        $this->rule('Overheat', 'R-L001', 0.85, [$this->hot, $this->noisyFan]);
        $this->rule('Kerusakan LCD', 'R-L004', 0.90, [$this->stripedScreen]);
    }

    public function test_questions_the_complaint_already_answers_are_not_asked_again(): void
    {
        $response = $this->post(route('diagnosis.store'), $this->submission('Laptop saya panas sekali'));

        $consultation = Consultation::sole();
        $response->assertRedirect(route('diagnosis.questions', $consultation));
        $this->assertDatabaseHas('consultation_answers', [
            'consultation_id' => $consultation->id,
            'symptom_id' => $this->hot->id,
            'answer' => true,
            'source' => ConsultationAnswer::SOURCE_COMPLAINT,
        ]);

        $this->get(route('diagnosis.questions', $consultation))
            ->assertOk()
            ->assertSeeInOrder([$this->stripedScreen->question, 'Yang sudah kami ketahui', $this->hot->question, 'Dari keluhan Anda']);
    }

    public function test_negated_symptoms_in_the_complaint_are_not_taken_as_yes(): void
    {
        $this->post(route('diagnosis.store'), $this->submission('Laptop saya tidak panas, tapi layarnya bergaris'));

        $consultation = Consultation::sole();
        $this->assertDatabaseMissing('consultation_answers', ['symptom_id' => $this->hot->id]);
        $this->assertDatabaseHas('consultation_answers', ['symptom_id' => $this->stripedScreen->id, 'answer' => true]);
        $this->assertSame('completed', $consultation->refresh()->status);
    }

    public function test_diagnosis_concludes_without_questions_when_the_complaint_is_enough(): void
    {
        $response = $this->post(route('diagnosis.store'), $this->submission('Layar laptop saya bergaris'));

        $consultation = Consultation::sole();
        $response->assertRedirect(route('diagnosis.result', $consultation));
        $this->assertSame('Kerusakan LCD', $consultation->diagnosis->name);
        $this->assertEquals(90, $consultation->confidence);
    }

    public function test_only_relevant_questions_are_asked_one_at_a_time(): void
    {
        $this->post(route('diagnosis.store'), $this->submission('Laptop saya bermasalah'));
        $consultation = Consultation::sole();

        $this->assertNextQuestion($consultation, $this->stripedScreen);
        $this->answer($consultation, $this->stripedScreen, false)->assertRedirect(route('diagnosis.questions', $consultation));

        $this->assertNextQuestion($consultation, $this->hot);
        $this->answer($consultation, $this->hot, true);

        $this->assertNextQuestion($consultation, $this->noisyFan);
        $this->answer($consultation, $this->noisyFan, true)->assertRedirect(route('diagnosis.result', $consultation));

        $consultation->refresh();
        $this->assertSame('Overheat', $consultation->diagnosis->name);
        $this->assertSame(3, $consultation->answers()->count());
    }

    public function test_questioning_stops_once_no_other_diagnosis_could_score_higher(): void
    {
        $this->post(route('diagnosis.store'), $this->submission('Laptop saya bermasalah'));
        $consultation = Consultation::sole();

        $this->answer($consultation, $this->stripedScreen, true)->assertRedirect(route('diagnosis.result', $consultation));

        $this->assertSame(1, $consultation->answers()->count());
        $this->assertSame('Kerusakan LCD', $consultation->refresh()->diagnosis->name);
    }

    public function test_questions_that_can_reveal_a_dangerous_condition_are_asked_first(): void
    {
        $burning = Symptom::create(['device_id' => $this->laptop->id, 'code' => 'L009', 'question' => 'Apakah tercium bau hangus?']);
        $this->rule('Korsleting', 'R-L009', 0.70, [$burning], 'critical');

        $this->post(route('diagnosis.store'), $this->submission('Laptop saya bermasalah'));

        $this->assertNextQuestion(Consultation::sole(), $burning);
    }

    public function test_user_can_change_an_automatically_detected_answer(): void
    {
        $this->post(route('diagnosis.store'), $this->submission('Layar laptop saya bergaris'));
        $consultation = Consultation::sole();

        $this->get(route('diagnosis.questions', ['consultation' => $consultation, 'ubah' => $this->stripedScreen->id]))
            ->assertOk()
            ->assertSee('Ubah Jawaban')
            ->assertSee($this->stripedScreen->question);

        $this->answer($consultation, $this->stripedScreen, false)->assertRedirect(route('diagnosis.questions', $consultation));

        $this->assertDatabaseHas('consultation_answers', [
            'symptom_id' => $this->stripedScreen->id,
            'answer' => false,
            'source' => ConsultationAnswer::SOURCE_USER,
        ]);
        $this->assertSame('in_progress', $consultation->refresh()->status);
    }

    public function test_clear_photo_findings_answer_questions_without_being_counted_twice(): void
    {
        $this->mock(ClaudeVisionClient::class, function (MockInterface $mock): void {
            $mock->shouldReceive('isConfigured')->andReturnTrue();
            $mock->shouldReceive('analyze')->once()->andReturn([
                'device_id' => $this->laptop->id,
                'device_label' => 'laptop',
                'brand' => '',
                'model' => '',
                'image_quality' => 'clear',
                'summary' => 'Layar menampilkan garis vertikal.',
                'visual_conditions' => ['garis vertikal di layar'],
                'symptoms' => [
                    ['symptom_id' => $this->stripedScreen->id, 'assessment' => 'visible', 'confidence' => 0.95, 'reason' => 'Garis terlihat jelas.'],
                    ['symptom_id' => $this->noisyFan->id, 'assessment' => 'visible', 'confidence' => 0.5, 'reason' => 'Kurang yakin.'],
                ],
            ]);
        });

        $this->post(route('diagnosis.store'), $this->submission('Tolong dicek'));

        $consultation = Consultation::sole();
        $this->assertDatabaseHas('consultation_answers', [
            'symptom_id' => $this->stripedScreen->id,
            'answer' => true,
            'source' => ConsultationAnswer::SOURCE_PHOTO,
        ]);
        $this->assertDatabaseMissing('consultation_answers', ['symptom_id' => $this->noisyFan->id]);
        $this->assertEquals(90, $consultation->refresh()->confidence);
    }

    public function test_answer_for_a_symptom_of_another_device_is_rejected(): void
    {
        $this->post(route('diagnosis.store'), $this->submission('Laptop saya bermasalah'));
        $consultation = Consultation::sole();
        $otherDevice = Device::create(['category_id' => $this->laptop->category_id, 'name' => 'AC Split']);
        $foreignSymptom = Symptom::create(['device_id' => $otherDevice->id, 'code' => 'A001', 'question' => 'Apakah AC tidak dingin?']);

        $this->answer($consultation, $foreignSymptom, true)->assertSessionHasErrors('symptom_id');

        $this->assertSame(0, $consultation->answers()->count());
    }

    /**
     * @param  list<Symptom>  $symptoms
     */
    private function rule(string $diagnosisName, string $ruleCode, float $weight, array $symptoms, string $severity = 'medium'): void
    {
        $diagnosis = Diagnosis::create([
            'device_id' => $this->laptop->id,
            'name' => $diagnosisName,
            'severity' => $severity,
            'repairability' => 'self_repair',
        ]);
        $rule = Rule::create(['diagnosis_id' => $diagnosis->id, 'rule_code' => $ruleCode, 'confidence_weight' => $weight]);

        foreach ($symptoms as $symptom) {
            RuleSymptom::create(['rule_id' => $rule->id, 'symptom_id' => $symptom->id, 'expected_answer' => true]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function submission(string $complaint): array
    {
        return ['initial_complaint' => $complaint, 'images' => [UploadedFile::fake()->image('foto.jpg')]];
    }

    private function answer(Consultation $consultation, Symptom $symptom, bool $answer): TestResponse
    {
        return $this->post(route('diagnosis.answers', $consultation), ['symptom_id' => $symptom->id, 'answer' => $answer ? '1' : '0']);
    }

    private function assertNextQuestion(Consultation $consultation, Symptom $expected): void
    {
        $this->get(route('diagnosis.questions', $consultation))
            ->assertOk()
            ->assertSee('name="symptom_id" value="'.$expected->id.'"', false);
    }
}
