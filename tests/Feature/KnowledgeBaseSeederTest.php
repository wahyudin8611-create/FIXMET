<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\RepairGuide;
use App\Models\RuleSymptom;
use App\Models\Symptom;
use App\Services\DeviceRecognitionService;
use App\Services\ExpertSystemService;
use Database\Seeders\KnowledgeBaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class KnowledgeBaseSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * @param  array<string, bool>  $answers  symptom code => answer
     */
    #[DataProvider('expectedDiagnoses')]
    public function test_seeded_rules_reach_the_expected_diagnosis(string $deviceName, array $answers, string $expectedDiagnosis): void
    {
        $device = Device::where('name', $deviceName)->sole();
        $symptoms = Symptom::where('device_id', $device->id)->get();
        $answersById = $symptoms->mapWithKeys(fn (Symptom $symptom) => [$symptom->id => $answers[$symptom->code] ?? false])->all();

        $results = app(ExpertSystemService::class)->processAnswers($device->id, $answersById);

        $this->assertSame($expectedDiagnosis, $results[0]['diagnosis']->name);
    }

    /**
     * @return array<string, array{string, array<string, bool>, string}>
     */
    public static function expectedDiagnoses(): array
    {
        return [
            'swollen phone battery' => ['HP Android', ['H001' => true, 'H008' => true], 'Baterai Menggembung'],
            'dirty phone charging port' => ['HP Android', ['H003' => true, 'H004' => true], 'Port Charger Kotor / Longgar'],
            'cracked phone screen' => ['HP Android', ['H005' => true], 'Layar Pecah / LCD Rusak'],
            'washer burning smell' => ['Mesin Cuci Top Load', ['M001' => true, 'M008' => true], 'Korsleting / Gangguan Kelistrikan'],
            'washer not draining' => ['Mesin Cuci Top Load', ['M004' => true, 'M009' => true], 'Saluran Pembuangan Tersumbat'],
            'dripping air conditioner' => ['AC Split', ['A002' => true], 'Saluran Pembuangan Air (Drain) Tersumbat'],
        ];
    }

    #[DataProvider('everydayComplaints')]
    public function test_device_is_recognised_from_everyday_complaints(string $complaint, ?string $expectedDevice): void
    {
        $device = app(DeviceRecognitionService::class)->recognizeFromText($complaint);

        $this->assertSame($expectedDevice, $device?->name);
    }

    /**
     * @return array<string, array{string, string|null}>
     */
    public static function everydayComplaints(): array
    {
        return [
            'iphone' => ['iPhone saya baterainya cepat habis', 'HP Android'],
            'phone brand' => ['Layar Oppo A5 saya bergaris', 'HP Android'],
            'laptop brand' => ['Acer saya tiba-tiba mati sendiri', 'Laptop'],
            'laptop made by hp' => ['Laptop HP saya panas sekali', 'Laptop'],
            'air conditioner' => ['AC di kamar meneteskan air', 'AC Split'],
            'washing machine' => ['Mesin cuci tidak mau berputar', 'Mesin Cuci Top Load'],
            'unknown device' => ['Kulkas saya tidak dingin', null],
        ];
    }

    public function test_every_rule_only_uses_symptoms_of_its_own_device(): void
    {
        $mismatched = RuleSymptom::with('rule.diagnosis', 'symptom')->get()
            ->filter(fn (RuleSymptom $condition) => $condition->symptom->device_id !== $condition->rule->diagnosis->device_id);

        $this->assertCount(0, $mismatched);
    }

    public function test_every_self_repair_diagnosis_has_solutions_and_a_guide(): void
    {
        $incomplete = Diagnosis::whereIn('code', ['D-H003', 'D-H007', 'D-M001', 'D-M002', 'D-M003', 'D-A002', 'D-A003'])
            ->withCount('solutions', 'repairGuides')
            ->get()
            ->filter(fn (Diagnosis $diagnosis) => $diagnosis->solutions_count === 0 || $diagnosis->repair_guides_count === 0);

        $this->assertCount(0, $incomplete);
    }

    public function test_running_the_seeder_again_does_not_duplicate_knowledge(): void
    {
        $counts = [Symptom::count(), Diagnosis::count(), RuleSymptom::count(), RepairGuide::count()];

        $this->seed(KnowledgeBaseSeeder::class);

        $this->assertSame($counts, [Symptom::count(), Diagnosis::count(), RuleSymptom::count(), RepairGuide::count()]);
    }
}
