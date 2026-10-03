<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\Technician;
use App\Models\User;
use App\Services\CostEstimationService;
use App\Services\VisionModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CostEstimationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Paksa jalur fallback berbasis aturan (tanpa panggilan AI nyata).
        $this->app->instance(VisionModel::class, new class implements VisionModel
        {
            public function isConfigured(): bool
            {
                return false;
            }

            public function analyze(string $system, array $images, string $text, array $schema): ?array
            {
                return null;
            }
        });
    }

    private function verifiedTechnician(int $fee): Technician
    {
        return Technician::create([
            'user_id' => User::factory()->technician()->create()->id,
            'specialization' => 'Laptop & Komputer',
            'service_area' => 'Jakarta',
            'service_fee' => $fee,
            'status' => 'verified',
            'is_verified' => true,
            'is_available' => true,
            'rating' => 4.8,
            'completed_jobs' => 10,
            'experience_years' => 5,
        ]);
    }

    private function laptopConsultation(string $severity): Consultation
    {
        $category = Category::create(['name' => 'Laptop & Komputer']);
        $device = Device::create(['category_id' => $category->id, 'name' => 'Laptop']);
        $diagnosis = Diagnosis::create([
            'device_id' => $device->id,
            'name' => 'Kerusakan Motherboard',
            'severity' => $severity,
            'repairability' => 'professional_only',
        ]);

        return Consultation::create([
            'user_id' => null, // tamu
            'device_id' => $device->id,
            'diagnosis_id' => $diagnosis->id,
            'consultation_code' => 'CONS-TEST-1',
            'status' => 'completed',
            'initial_complaint' => 'Laptop mati total tidak bisa menyala.',
        ]);
    }

    public function test_rule_based_estimate_uses_the_documented_formula(): void
    {
        $this->verifiedTechnician(100_000); // median tarif/jam = 100.000
        $consultation = $this->laptopConsultation('high'); // high → "berat"

        $estimate = app(CostEstimationService::class)->for($consultation->fresh());

        // laptop/berat: sparepart [900.000, 2.500.000]; jam berat = 4
        $this->assertSame('berat', $estimate['damage_level']);
        $this->assertSame('rule', $estimate['source']);
        $this->assertSame(4, $estimate['estimated_hours']);
        $this->assertSame(900_000, $estimate['parts_total_min']);
        $this->assertSame(2_500_000, $estimate['parts_total_max']);
        $this->assertSame(100_000, $estimate['hourly_reference']);
        $this->assertSame(400_000, $estimate['labor_reference']); // 100.000 × 4 jam

        // Platform = flat 10.000 + 10% dari jasa 400.000 = 50.000
        $this->assertSame(50_000, $estimate['platform_fee']);

        // Total = (tarif/jam × jam) + sparepart + platform
        $this->assertSame(400_000 + 900_000 + 50_000, $estimate['total_min']); // 1.350.000
        $this->assertSame(400_000 + 2_500_000 + 50_000, $estimate['total_max']); // 2.950.000

        $this->assertNotNull($consultation->fresh()->cost_estimate);
    }

    public function test_per_technician_estimate_uses_that_technicians_hourly_rate(): void
    {
        $this->verifiedTechnician(100_000);
        $consultation = $this->laptopConsultation('high'); // 4 jam

        $service = app(CostEstimationService::class);
        $estimate = $service->generate($consultation);

        // Teknisi murah: 80.000/jam × 4 = 320.000 jasa; platform = 10.000 + 32.000 = 42.000
        $cheap = $service->perTechnician($estimate, $this->verifiedTechnician(80_000));
        $this->assertSame(320_000 + 900_000 + 42_000, $cheap['total_min']); // 1.262.000

        // Teknisi mahal: 250.000/jam × 4 = 1.000.000 jasa; platform = 10.000 + 100.000 = 110.000
        $pricey = $service->perTechnician($estimate, $this->verifiedTechnician(250_000));
        $this->assertSame(1_000_000 + 2_500_000 + 110_000, $pricey['total_max']); // 3.610.000
    }

    public function test_technician_list_shows_dynamic_estimate_when_opened_from_a_consultation(): void
    {
        $this->verifiedTechnician(100_000);
        $consultation = $this->laptopConsultation('high');

        $this->get(route('technicians.index', ['consultation' => $consultation->access_token]))
            ->assertOk()
            ->assertSee('Estimasi Kerusakan:')
            ->assertSee('Kerusakan Berat')
            ->assertSee('Rp1.350.000')
            ->assertSee('Rp2.950.000');
    }

    public function test_guest_consultation_cannot_be_opened_by_guessing_its_id(): void
    {
        $this->verifiedTechnician(100_000);
        $consultation = $this->laptopConsultation('high');

        $this->get(route('technicians.index', ['consultation' => $consultation->id]))
            ->assertOk()
            ->assertDontSee('Estimasi Kerusakan:')
            ->assertSee('Analisis Kerusakan Dahulu');

        $this->assertNull($consultation->refresh()->cost_estimate);
    }

    public function test_price_is_locked_until_the_user_analyses_the_damage(): void
    {
        $this->verifiedTechnician(100_000);

        $this->get(route('technicians.index'))
            ->assertOk()
            ->assertSee('Analisis Kerusakan Dahulu')   // CTA pengganti harga
            ->assertDontSee('Rp100.000')               // harga disembunyikan
            ->assertDontSee('Estimasi Kerusakan:');
    }
}
