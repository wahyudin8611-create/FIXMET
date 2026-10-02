<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\ConsultationImage;
use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\RepairGuide;
use App\Models\Rule;
use App\Models\RuleSymptom;
use App\Models\Solution;
use App\Models\Symptom;
use App\Models\Technician;
use App\Models\User;
use App\Services\ClaudeVisionClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

class GuestDiagnosisTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    private Device $device;

    private Symptom $overheatSymptom;

    private Symptom $batterySymptom;

    private Diagnosis $diagnosis;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->category = Category::create(['name' => 'Laptop & Komputer']);
        $this->device = Device::create(['category_id' => $this->category->id, 'name' => 'Laptop', 'keywords' => 'laptop, notebook, macbook']);
        $this->overheatSymptom = Symptom::create([
            'device_id' => $this->device->id,
            'code' => 'L002',
            'question' => 'Apakah laptop terasa sangat panas saat digunakan?',
        ]);
        $this->batterySymptom = Symptom::create([
            'device_id' => $this->device->id,
            'code' => 'L003',
            'question' => 'Apakah baterai tidak bisa mengisi daya?',
        ]);
        $this->diagnosis = Diagnosis::create([
            'device_id' => $this->device->id,
            'name' => 'Overheat / Panas Berlebih',
            'severity' => 'medium',
            'repairability' => 'self_repair',
        ]);

        $rule = Rule::create([
            'diagnosis_id' => $this->diagnosis->id,
            'rule_code' => 'R-L001',
            'confidence_weight' => 0.85,
        ]);
        RuleSymptom::create([
            'rule_id' => $rule->id,
            'symptom_id' => $this->overheatSymptom->id,
            'expected_answer' => true,
        ]);
        Solution::create([
            'diagnosis_id' => $this->diagnosis->id,
            'title' => 'Bersihkan Heatsink dan Kipas',
        ]);
    }

    public function test_guest_can_open_the_diagnosis_form(): void
    {
        $this->get(route('diagnosis.create'))
            ->assertOk()
            ->assertSee('Mulai Diagnosis Kerusakan');
    }

    public function test_guest_can_start_a_diagnosis_without_an_account(): void
    {
        $response = $this->post(route('diagnosis.store'), $this->validSubmission());

        $consultation = Consultation::sole();
        $response->assertRedirect(route('diagnosis.questions', $consultation));
        $this->assertNull($consultation->user_id);
        $this->assertSame(40, strlen($consultation->access_token));
        $this->assertSame([$consultation->id], session(Consultation::GUEST_SESSION_KEY));
        Storage::disk('public')->assertExists($consultation->images()->sole()->image_path);
    }

    public function test_guest_must_upload_a_photo(): void
    {
        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'images' => []])
            ->assertSessionHasErrors('images');

        $this->assertDatabaseCount('consultations', 0);
    }

    public function test_guest_receives_a_diagnosis_from_their_answers(): void
    {
        $consultation = $this->guestConsultation();

        $this->get(route('diagnosis.questions', $consultation))
            ->assertOk()
            ->assertSee('Apakah laptop terasa sangat panas saat digunakan?');

        $this->post(route('diagnosis.answers', $consultation), [
            'symptom_'.$this->overheatSymptom->id => '1',
            'symptom_'.$this->batterySymptom->id => '0',
        ])->assertRedirect(route('diagnosis.result', $consultation));

        $consultation->refresh();
        $this->assertSame('completed', $consultation->status);
        $this->assertSame($this->diagnosis->id, $consultation->diagnosis_id);
        $this->assertEquals(85, $consultation->confidence);

        $this->get(route('diagnosis.result', $consultation))
            ->assertOk()
            ->assertSee('Overheat / Panas Berlebih')
            ->assertSee('85%')
            ->assertSee('Bersihkan Heatsink dan Kipas');
    }

    public function test_answers_matching_no_rule_report_that_no_diagnosis_was_found(): void
    {
        $consultation = $this->guestConsultation();

        $this->post(route('diagnosis.answers', $consultation), [
            'symptom_'.$this->overheatSymptom->id => '0',
            'symptom_'.$this->batterySymptom->id => '0',
        ]);

        $this->assertSame('no_diagnosis', $consultation->refresh()->status);
        $this->get(route('diagnosis.result', $consultation))
            ->assertOk()
            ->assertSee('Diagnosis Tidak Dapat Ditentukan');
    }

    public function test_device_is_recognised_from_the_complaint_without_choosing_a_category(): void
    {
        $phone = $this->phoneDevice();

        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'initial_complaint' => 'Redmi saya layarnya retak setelah jatuh']);

        $this->assertSame($phone->id, Consultation::sole()->device_id);
    }

    public function test_device_mentioned_first_wins_when_a_brand_name_is_shared(): void
    {
        $this->phoneDevice();

        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'initial_complaint' => 'Laptop HP saya cepat panas']);

        $this->assertSame($this->device->id, Consultation::sole()->device_id);
    }

    public function test_unrecognised_device_returns_to_the_form_without_keeping_the_photos(): void
    {
        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'initial_complaint' => 'Barang saya rusak, tolong dicek'])
            ->assertSessionHasErrors(['initial_complaint' => 'Kami belum bisa mengenali perangkatnya. Sebutkan jenis perangkat di keluhan Anda, misalnya "HP saya layarnya retak". Perangkat yang didukung: Laptop.']);

        $this->assertDatabaseCount('consultations', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_ai_recognises_the_device_and_its_brand_from_the_photos(): void
    {
        $this->mockVisionResult([
            'device_id' => $this->device->id,
            'device_label' => 'laptop',
            'brand' => 'ASUS',
            'model' => 'VivoBook 14',
        ]);

        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'initial_complaint' => 'Layarnya bergaris sejak kemarin']);

        $consultation = Consultation::sole();
        $this->assertSame($this->device->id, $consultation->device_id);
        $this->assertSame('ASUS', $consultation->device_brand);
        $this->assertSame('VivoBook 14', $consultation->device_model);
    }

    public function test_device_the_ai_sees_but_fixmet_does_not_support_is_explained(): void
    {
        $this->mockVisionResult(['device_id' => 0, 'device_label' => 'kulkas']);

        $this->post(route('diagnosis.store'), [...$this->validSubmission(), 'initial_complaint' => 'Tidak dingin lagi dan berisik'])
            ->assertSessionHasErrors(['initial_complaint' => 'Perangkat Anda terlihat seperti kulkas, yang belum bisa didiagnosis otomatis oleh FIXMET. Silakan cari teknisi untuk pemeriksaan langsung.']);

        $this->assertDatabaseCount('consultations', 0);
    }

    public function test_photo_with_an_unusual_jpeg_extension_is_kept(): void
    {
        $source = UploadedFile::fake()->image('source.jpg');
        $jpeg = file_get_contents($source->getRealPath());

        $this->post(route('diagnosis.store'), [
            ...$this->validSubmission(),
            'images' => [UploadedFile::fake()->createWithContent('kamera.jfif', $jpeg)],
        ]);

        $image = Consultation::sole()->images()->sole();
        $this->assertStringEndsWith('.jpg', $image->image_path);
        Storage::disk('public')->assertExists($image->image_path);
    }

    public function test_unanswered_diagnosis_result_sends_the_visitor_to_the_questions(): void
    {
        $consultation = $this->guestConsultation();

        $this->get(route('diagnosis.result', $consultation))
            ->assertRedirect(route('diagnosis.questions', $consultation));
    }

    public function test_answering_again_without_a_match_clears_the_previous_diagnosis(): void
    {
        $consultation = $this->guestConsultation();
        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '0']);

        $consultation->refresh();
        $this->assertSame('no_diagnosis', $consultation->status);
        $this->assertNull($consultation->diagnosis_id);
        $this->assertNull($consultation->confidence);
        $this->assertNull($consultation->all_diagnoses);
    }

    public function test_diagnosis_matched_by_several_rules_is_listed_once_with_its_best_score(): void
    {
        $secondRule = Rule::create([
            'diagnosis_id' => $this->diagnosis->id,
            'rule_code' => 'R-L001-B',
            'confidence_weight' => 0.60,
        ]);
        RuleSymptom::create([
            'rule_id' => $secondRule->id,
            'symptom_id' => $this->batterySymptom->id,
            'expected_answer' => true,
        ]);
        $consultation = $this->guestConsultation();

        $this->post(route('diagnosis.answers', $consultation), [
            'symptom_'.$this->overheatSymptom->id => '1',
            'symptom_'.$this->batterySymptom->id => '1',
        ]);

        $this->assertSame(
            [['diagnosis_id' => $this->diagnosis->id, 'name' => 'Overheat / Panas Berlebih', 'confidence' => 85]],
            $consultation->refresh()->all_diagnoses,
        );
    }

    public function test_uploaded_photos_are_analysed_by_ai_and_the_evidence_is_stored(): void
    {
        $this->mock(ClaudeVisionClient::class, function (MockInterface $mock): void {
            $mock->shouldReceive('isConfigured')->andReturnTrue();
            $mock->shouldReceive('analyze')
                ->once()
                ->withArgs(function (string $system, array $content, array $schema): bool {
                    $text = collect($content)->firstWhere('type', 'text')['text'];

                    return collect($content)->where('type', 'image')->count() === 1
                        && collect($content)->firstWhere('type', 'image')['source']['mediaType'] === 'image/jpeg'
                        && str_contains($text, "device_id {$this->device->id}: Laptop (Laptop & Komputer)")
                        && str_contains($text, "symptom_id {$this->overheatSymptom->id}: Apakah laptop terasa sangat panas saat digunakan?")
                        && str_contains($text, '<complaint>Laptop cepat panas lalu mati sendiri.</complaint>');
                })
                ->andReturn([
                    'device_id' => $this->device->id,
                    'device_label' => 'laptop',
                    'brand' => '',
                    'model' => '',
                    'image_quality' => 'clear',
                    'summary' => 'Terlihat debu tebal di ventilasi.',
                    'visual_conditions' => ['debu tebal di ventilasi'],
                    'symptoms' => [
                        ['symptom_id' => $this->overheatSymptom->id, 'assessment' => 'visible', 'confidence' => 1.4, 'reason' => 'Ventilasi tertutup debu.'],
                        ['symptom_id' => 999, 'assessment' => 'visible', 'confidence' => 0.9, 'reason' => 'Gejala yang tidak dikenal.'],
                    ],
                    'ai_model' => 'claude-opus-5-5',
                ]);
        });

        $this->post(route('diagnosis.store'), $this->validSubmission());

        $evidence = Consultation::sole()->visual_evidence;
        $this->assertSame('clear', $evidence['image_quality']);
        $this->assertSame(['debu tebal di ventilasi'], $evidence['visual_conditions']);
        $this->assertSame(
            [['symptom_id' => $this->overheatSymptom->id, 'assessment' => 'visible', 'confidence' => 1, 'reason' => 'Ventilasi tertutup debu.']],
            $evidence['symptoms'],
        );
    }

    public function test_diagnosis_continues_without_photo_evidence_when_ai_analysis_fails(): void
    {
        $this->mock(ClaudeVisionClient::class, function (MockInterface $mock): void {
            $mock->shouldReceive('isConfigured')->andReturnTrue();
            $mock->shouldReceive('analyze')->once()->andReturnNull();
        });

        $response = $this->post(route('diagnosis.store'), $this->validSubmission());

        $consultation = Consultation::sole();
        $response->assertRedirect(route('diagnosis.questions', $consultation));
        $this->assertNull($consultation->visual_evidence);
    }

    public function test_photo_evidence_confirming_a_rule_raises_its_score(): void
    {
        $consultation = $this->guestConsultation(['visual_evidence' => $this->visualEvidence('visible', 0.4)]);

        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $consultation->refresh();
        $this->assertEquals(93.5, $consultation->confidence);
        $this->assertSame(85, $consultation->all_diagnoses[0]['base_confidence']);
        $this->assertSame(0.4, $consultation->all_diagnoses[0]['visual_support']);
    }

    public function test_photo_evidence_contradicting_a_rule_lowers_its_score(): void
    {
        $consultation = $this->guestConsultation(['visual_evidence' => $this->visualEvidence('contradicted', 0.8)]);

        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->assertEquals(68, $consultation->refresh()->confidence);
    }

    public function test_unclear_photos_do_not_change_the_score(): void
    {
        $consultation = $this->guestConsultation([
            'visual_evidence' => [...$this->visualEvidence('visible', 0.9), 'image_quality' => 'unclear'],
        ]);

        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->assertEquals(85, $consultation->refresh()->confidence);
    }

    public function test_result_page_shows_the_ai_photo_findings(): void
    {
        $consultation = $this->guestConsultation(['visual_evidence' => [
            ...$this->visualEvidence('visible', 0.4),
            'summary' => 'Ventilasi laptop tertutup debu tebal.',
            'visual_conditions' => ['debu tebal di ventilasi samping'],
        ]]);
        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->get(route('diagnosis.result', $consultation))
            ->assertOk()
            ->assertSeeInOrder(['Overheat / Panas Berlebih', 'Analisis Foto AI'])
            ->assertSee('85% dari jawaban')
            ->assertSee('94% setelah analisis foto')
            ->assertSee('Ventilasi laptop tertutup debu tebal.')
            ->assertSee('debu tebal di ventilasi samping')
            ->assertSee('Terlihat di foto')
            ->assertSee('jawaban Anda: Ya');
    }

    public function test_result_page_warns_when_photos_are_unclear(): void
    {
        $consultation = $this->guestConsultation([
            'visual_evidence' => [...$this->visualEvidence('visible', 0.9), 'image_quality' => 'unclear'],
        ]);
        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->get(route('diagnosis.result', $consultation))
            ->assertOk()
            ->assertSee('Foto kurang jelas, sehingga tidak dipakai untuk menghitung skor diagnosis.')
            ->assertDontSee('setelah analisis foto');
    }

    public function test_result_page_hides_the_ai_section_when_no_analysis_ran(): void
    {
        $consultation = $this->guestConsultation();
        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->get(route('diagnosis.result', $consultation))
            ->assertOk()
            ->assertDontSee('Analisis Foto AI');
    }

    public function test_guest_sees_how_long_their_result_is_kept(): void
    {
        $consultation = $this->guestConsultation();
        $this->post(route('diagnosis.answers', $consultation), ['symptom_'.$this->overheatSymptom->id => '1']);

        $this->get(route('diagnosis.result', $consultation))
            ->assertSee('Hasil ini disimpan selama 7 hari');

        $owner = User::factory()->create();
        $consultation->update(['user_id' => $owner->id]);

        $this->actingAs($owner)
            ->get(route('diagnosis.result', $consultation))
            ->assertDontSee('Hasil ini disimpan selama 7 hari');
    }

    public function test_diagnosis_urls_cannot_be_guessed_from_the_id(): void
    {
        $consultation = $this->guestConsultation();

        $this->get('/diagnosis/'.$consultation->id)->assertNotFound();
    }

    public function test_guest_is_asked_to_sign_in_to_open_a_saved_diagnosis(): void
    {
        $consultation = $this->guestConsultation(['user_id' => User::factory()->create()->id]);

        $this->get(route('diagnosis.result', $consultation))->assertRedirect(route('login'));
    }

    public function test_user_cannot_open_another_users_saved_diagnosis(): void
    {
        $consultation = $this->guestConsultation(['user_id' => User::factory()->create()->id]);

        $this->actingAs(User::factory()->create())
            ->get(route('diagnosis.result', $consultation))
            ->assertForbidden();
    }

    public function test_signing_in_moves_guest_diagnoses_into_the_account(): void
    {
        $user = User::factory()->create();
        $this->post(route('diagnosis.store'), $this->validSubmission());

        $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('user.dashboard'));

        $this->assertSame($user->id, Consultation::sole()->user_id);
        $this->assertNull(session(Consultation::GUEST_SESSION_KEY));
    }

    public function test_registering_moves_guest_diagnoses_into_the_new_account(): void
    {
        $this->post(route('diagnosis.store'), $this->validSubmission());

        $this->post(route('register.user.store'), [
            'name' => 'Rina',
            'email' => 'rina@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.dashboard'));

        $this->assertSame(User::where('email', 'rina@example.com')->sole()->id, Consultation::sole()->user_id);
    }

    public function test_technician_signing_in_does_not_take_guest_diagnoses(): void
    {
        $technician = User::factory()->technician()->create();
        $this->post(route('diagnosis.store'), $this->validSubmission());

        $this->post(route('login'), ['email' => $technician->email, 'password' => 'password']);

        $this->assertNull(Consultation::sole()->user_id);
    }

    public function test_admin_can_list_guest_diagnoses(): void
    {
        $this->guestConsultation();

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('admin.consultations.index'))
            ->assertOk()
            ->assertSee('Tamu');
    }

    public function test_guest_diagnosis_submissions_are_rate_limited(): void
    {
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post(route('diagnosis.store'))->assertRedirect();
        }

        $this->post(route('diagnosis.store'))->assertTooManyRequests();
    }

    public function test_expired_guest_diagnoses_are_pruned_with_their_photos(): void
    {
        $expired = $this->guestConsultation();
        $expired->forceFill(['created_at' => now()->subDays(Consultation::GUEST_RETENTION_DAYS + 1)])->save();
        Storage::disk('public')->put('consultations/expired.jpg', 'photo');
        ConsultationImage::create(['consultation_id' => $expired->id, 'image_path' => 'consultations/expired.jpg']);

        $recent = $this->guestConsultation();
        $saved = $this->guestConsultation(['user_id' => User::factory()->create()->id]);
        $saved->forceFill(['created_at' => now()->subDays(Consultation::GUEST_RETENTION_DAYS + 1)])->save();

        $this->artisan('model:prune', ['--model' => [Consultation::class]])->assertSuccessful();

        $this->assertModelMissing($expired);
        $this->assertModelExists($recent);
        $this->assertModelExists($saved);
        Storage::disk('public')->assertMissing('consultations/expired.jpg');
    }

    public function test_guest_can_read_a_repair_guide(): void
    {
        $guide = RepairGuide::create([
            'diagnosis_id' => $this->diagnosis->id,
            'title' => 'Cara Membersihkan Heatsink Laptop',
            'tools_needed' => 'Obeng PH0',
        ]);

        $this->get(route('repair-guides.show', $guide))
            ->assertOk()
            ->assertSee('Cara Membersihkan Heatsink Laptop')
            ->assertSee('Obeng PH0');
    }

    public function test_guest_can_view_a_technician_profile_but_booking_requires_an_account(): void
    {
        $technician = Technician::create([
            'user_id' => User::factory()->technician()->create()->id,
            'specialization' => 'Laptop & Komputer',
            'service_area' => 'Jakarta',
            'status' => 'verified',
            'is_verified' => true,
        ]);

        $this->get(route('technicians.show', $technician))->assertOk();

        $this->get(route('user.bookings.create', ['technician_id' => $technician->id]))
            ->assertRedirect(route('login'));
    }

    /**
     * @return array<string, mixed>
     */
    private function validSubmission(): array
    {
        return [
            'initial_complaint' => 'Laptop cepat panas lalu mati sendiri.',
            'images' => [UploadedFile::fake()->image('laptop.jpg')],
        ];
    }

    private function phoneDevice(): Device
    {
        $category = Category::create(['name' => 'Smartphone']);

        return Device::create(['category_id' => $category->id, 'name' => 'HP Android', 'keywords' => 'hp, handphone, redmi, iphone']);
    }

    /**
     * @param  array<string, mixed>  $result
     */
    private function mockVisionResult(array $result): void
    {
        $this->mock(ClaudeVisionClient::class, function (MockInterface $mock) use ($result): void {
            $mock->shouldReceive('isConfigured')->andReturnTrue();
            $mock->shouldReceive('analyze')->once()->andReturn([
                'device_label' => '',
                'brand' => '',
                'model' => '',
                'image_quality' => 'clear',
                'summary' => '',
                'visual_conditions' => [],
                'symptoms' => [],
                ...$result,
            ]);
        });
    }

    /**
     * @return array<string, mixed>
     */
    private function visualEvidence(string $assessment, float $confidence): array
    {
        return [
            'image_quality' => 'clear',
            'summary' => '',
            'visual_conditions' => [],
            'symptoms' => [
                ['symptom_id' => $this->overheatSymptom->id, 'assessment' => $assessment, 'confidence' => $confidence, 'reason' => ''],
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function guestConsultation(array $attributes = []): Consultation
    {
        return Consultation::create([
            'device_id' => $this->device->id,
            'consultation_code' => 'CONS-'.fake()->unique()->bothify('########'),
            'initial_complaint' => 'Laptop cepat panas.',
            'status' => 'in_progress',
            ...$attributes,
        ]);
    }
}
