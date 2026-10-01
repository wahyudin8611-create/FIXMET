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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $this->device = Device::create(['category_id' => $this->category->id, 'name' => 'Laptop']);
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
            'category_id' => $this->category->id,
            'device_id' => $this->device->id,
            'initial_complaint' => 'Laptop cepat panas lalu mati sendiri.',
            'images' => [UploadedFile::fake()->image('laptop.jpg')],
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
