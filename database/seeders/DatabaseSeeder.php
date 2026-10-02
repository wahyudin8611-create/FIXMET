<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Device;
use App\Models\Symptom;
use App\Models\Diagnosis;
use App\Models\Rule;
use App\Models\RuleSymptom;
use App\Models\Solution;
use App\Models\RepairGuide;
use App\Models\RepairStep;
use App\Models\Technician;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ───────────────────────────────────────────────
        $admin = User::create([
            'name' => 'Admin FIXMET',
            'email' => 'admin@fixmet.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081200000000',
            'email_verified_at' => now(),
        ]);

        // ── Demo Users ───────────────────────────────────────────────
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        $techUser1 = User::create([
            'name' => 'Ahmad Teknisi',
            'email' => 'ahmad@fixmet.id',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone' => '085678901234',
            'email_verified_at' => now(),
        ]);

        $techUser2 = User::create([
            'name' => 'Sari Perbaikan',
            'email' => 'sari@fixmet.id',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone' => '087890123456',
            'email_verified_at' => now(),
        ]);

        // ── Technicians ──────────────────────────────────────────────
        Technician::create([
            'user_id' => $techUser1->id,
            'specialization' => 'Laptop & Komputer',
            'description' => 'Spesialis perbaikan laptop semua merek, berpengalaman 7 tahun.',
            'service_area' => 'Jakarta, Bekasi',
            'service_fee' => 100000,
            'experience_years' => 7,
            'rating' => 4.8,
            'completed_jobs' => 150,
            'status' => 'verified',
            'is_verified' => true,
            'is_available' => true,
        ]);

        Technician::create([
            'user_id' => $techUser2->id,
            'specialization' => 'AC & Mesin Cuci',
            'description' => 'Teknisi AC dan peralatan rumah tangga bergaransi.',
            'service_area' => 'Karawang, Bekasi',
            'service_fee' => 85000,
            'experience_years' => 5,
            'rating' => 4.6,
            'completed_jobs' => 98,
            'status' => 'verified',
            'is_verified' => true,
            'is_available' => true,
        ]);

        // ── Categories ───────────────────────────────────────────────
        $catLaptop = Category::create(['name' => 'Laptop & Komputer', 'slug' => 'laptop-komputer', 'icon' => 'laptop', 'description' => 'Laptop, PC, Notebook']);
        $catAC = Category::create(['name' => 'AC & Pendingin', 'slug' => 'ac-pendingin', 'icon' => 'ac', 'description' => 'AC Split, Standing AC']);
        $catHp = Category::create(['name' => 'Smartphone', 'slug' => 'smartphone', 'icon' => 'smartphone', 'description' => 'HP Android & iOS']);
        $catMC = Category::create(['name' => 'Mesin Cuci', 'slug' => 'mesin-cuci', 'icon' => 'washer', 'description' => 'Mesin cuci front & top load']);

        // ── Devices ──────────────────────────────────────────────────
        $laptop = Device::create(['category_id' => $catLaptop->id, 'name' => 'Laptop', 'slug' => 'laptop', 'brand' => 'Semua Merek']);
        $ac = Device::create(['category_id' => $catAC->id, 'name' => 'AC Split', 'slug' => 'ac-split', 'brand' => 'Semua Merek']);
        $hp = Device::create(['category_id' => $catHp->id, 'name' => 'HP Android', 'slug' => 'hp-android']);
        $mc = Device::create(['category_id' => $catMC->id, 'name' => 'Mesin Cuci Top Load', 'slug' => 'mesin-cuci-top-load']);

        // ── Symptoms for Laptop ──────────────────────────────────────
        $s = [];
        $laptopSymptoms = [
            ['code' => 'L001', 'question' => 'Apakah laptop sering restart sendiri secara tiba-tiba?', 'weight' => 8],
            ['code' => 'L002', 'question' => 'Apakah laptop terasa sangat panas saat digunakan?', 'weight' => 7],
            ['code' => 'L003', 'question' => 'Apakah baterai tidak bisa mengisi daya?', 'weight' => 9],
            ['code' => 'L004', 'question' => 'Apakah layar berkedip atau menampilkan garis-garis?', 'weight' => 8],
            ['code' => 'L005', 'question' => 'Apakah laptop sangat lambat bahkan untuk tugas ringan?', 'weight' => 6],
            ['code' => 'L006', 'question' => 'Apakah kipas laptop berbunyi berisik tidak normal?', 'weight' => 7],
            ['code' => 'L007', 'question' => 'Apakah laptop tidak bisa booting / menyala sama sekali?', 'weight' => 10],
            ['code' => 'L008', 'question' => 'Apakah muncul layar biru (BSOD) saat laptop menyala?', 'weight' => 9],
        ];
        foreach ($laptopSymptoms as $sym) {
            $s[$sym['code']] = Symptom::create(array_merge($sym, ['device_id' => $laptop->id]));
        }

        // ── Symptoms for AC ──────────────────────────────────────────
        $acSymptoms = [
            ['code' => 'A001', 'question' => 'Apakah AC tidak mengeluarkan udara dingin?', 'weight' => 10],
            ['code' => 'A002', 'question' => 'Apakah air menetes dari unit indoor AC?', 'weight' => 8],
            ['code' => 'A003', 'question' => 'Apakah AC mengeluarkan bau tidak sedap?', 'weight' => 6],
            ['code' => 'A004', 'question' => 'Apakah AC berbunyi berisik (bunyi gemeretak/berdengung)?', 'weight' => 7],
            ['code' => 'A005', 'question' => 'Apakah remote AC tidak berfungsi sama sekali?', 'weight' => 5],
            ['code' => 'A006', 'question' => 'Apakah AC mati sendiri setelah beberapa menit menyala?', 'weight' => 9],
        ];
        foreach ($acSymptoms as $sym) {
            $s[$sym['code']] = Symptom::create(array_merge($sym, ['device_id' => $ac->id]));
        }

        // ── Diagnoses for Laptop ─────────────────────────────────────
        $dOverheat = Diagnosis::create([
            'device_id' => $laptop->id,
            'code' => 'D-L001',
            'name' => 'Overheat / Panas Berlebih',
            'description' => 'Laptop mengalami overheat karena penumpukan debu pada heatsink atau pasta thermal yang mengering.',
            'severity' => 'medium',
            'repairability' => 'self_repair',
            'recommendation' => 'Bersihkan kipas dan heatsink, ganti thermal paste.',
            'danger_signs' => 'Jika laptop mati mendadak saat panas, segera matikan dan biarkan dingin.',
        ]);

        $dBattery = Diagnosis::create([
            'device_id' => $laptop->id,
            'code' => 'D-L002',
            'name' => 'Baterai Rusak / Tidak Berfungsi',
            'description' => 'Baterai laptop tidak dapat menyimpan atau menerima daya listrik.',
            'severity' => 'medium',
            'repairability' => 'self_repair',
            'recommendation' => 'Ganti baterai dengan yang baru sesuai tipe laptop.',
        ]);

        $dHDD = Diagnosis::create([
            'device_id' => $laptop->id,
            'code' => 'D-L003',
            'name' => 'Kerusakan Hard Disk / SSD',
            'description' => 'Hard disk atau SSD mengalami kerusakan sektor, bad sector, atau kegagalan total.',
            'severity' => 'high',
            'repairability' => 'professional_only',
            'recommendation' => 'Segera backup data, bawa ke teknisi untuk penggantian storage.',
            'danger_signs' => 'Jangan biarkan terlalu lama — data bisa hilang permanen.',
        ]);

        $dLCD = Diagnosis::create([
            'device_id' => $laptop->id,
            'code' => 'D-L004',
            'name' => 'Kerusakan LCD / Panel Layar',
            'description' => 'Panel LCD laptop rusak, menampilkan garis, berkedip, atau layar gelap.',
            'severity' => 'high',
            'repairability' => 'professional_only',
            'recommendation' => 'Ganti panel LCD dengan yang kompatibel.',
        ]);

        // ── Diagnoses for AC ─────────────────────────────────────────
        $dFreon = Diagnosis::create([
            'device_id' => $ac->id,
            'code' => 'D-A001',
            'name' => 'Freon Habis / Bocor',
            'description' => 'Refrigerant (freon) AC habis atau bocor sehingga AC tidak dingin.',
            'severity' => 'medium',
            'repairability' => 'professional_only',
            'recommendation' => 'Isi ulang freon dan perbaiki kebocoran jika ada.',
        ]);

        $dACDirty = Diagnosis::create([
            'device_id' => $ac->id,
            'code' => 'D-A002',
            'name' => 'AC Kotor / Filter Tersumbat',
            'description' => 'Filter dan evaporator AC sangat kotor sehingga menghambat aliran udara.',
            'severity' => 'low',
            'repairability' => 'self_repair',
            'recommendation' => 'Cuci filter dan bersihkan unit indoor secara berkala.',
        ]);

        // ── Rules for Laptop ─────────────────────────────────────────
        $r1 = Rule::create(['diagnosis_id' => $dOverheat->id, 'rule_code' => 'R-L001', 'confidence_weight' => 0.85]);
        RuleSymptom::create(['rule_id' => $r1->id, 'symptom_id' => $s['L001']->id, 'expected_answer' => true]);
        RuleSymptom::create(['rule_id' => $r1->id, 'symptom_id' => $s['L002']->id, 'expected_answer' => true]);
        RuleSymptom::create(['rule_id' => $r1->id, 'symptom_id' => $s['L006']->id, 'expected_answer' => true]);

        $r2 = Rule::create(['diagnosis_id' => $dBattery->id, 'rule_code' => 'R-L002', 'confidence_weight' => 0.90]);
        RuleSymptom::create(['rule_id' => $r2->id, 'symptom_id' => $s['L003']->id, 'expected_answer' => true]);

        $r3 = Rule::create(['diagnosis_id' => $dHDD->id, 'rule_code' => 'R-L003', 'confidence_weight' => 0.80]);
        RuleSymptom::create(['rule_id' => $r3->id, 'symptom_id' => $s['L005']->id, 'expected_answer' => true]);
        RuleSymptom::create(['rule_id' => $r3->id, 'symptom_id' => $s['L008']->id, 'expected_answer' => true]);

        $r4 = Rule::create(['diagnosis_id' => $dLCD->id, 'rule_code' => 'R-L004', 'confidence_weight' => 0.88]);
        RuleSymptom::create(['rule_id' => $r4->id, 'symptom_id' => $s['L004']->id, 'expected_answer' => true]);

        // ── Rules for AC ─────────────────────────────────────────────
        $r5 = Rule::create(['diagnosis_id' => $dFreon->id, 'rule_code' => 'R-A001', 'confidence_weight' => 0.82]);
        RuleSymptom::create(['rule_id' => $r5->id, 'symptom_id' => $s['A001']->id, 'expected_answer' => true]);
        RuleSymptom::create(['rule_id' => $r5->id, 'symptom_id' => $s['A006']->id, 'expected_answer' => true]);

        $r6 = Rule::create(['diagnosis_id' => $dACDirty->id, 'rule_code' => 'R-A002', 'confidence_weight' => 0.78]);
        RuleSymptom::create(['rule_id' => $r6->id, 'symptom_id' => $s['A001']->id, 'expected_answer' => true]);
        RuleSymptom::create(['rule_id' => $r6->id, 'symptom_id' => $s['A003']->id, 'expected_answer' => true]);

        // ── Solutions ────────────────────────────────────────────────
        Solution::create([
            'diagnosis_id' => $dOverheat->id,
            'title' => 'Bersihkan Heatsink dan Kipas',
            'description' => 'Buka laptop, bersihkan debu dari heatsink dan kipas dengan kuas halus atau blower udara bertekanan rendah.',
            'solution_type' => 'corrective',
            'order_number' => 1,
        ]);

        Solution::create([
            'diagnosis_id' => $dOverheat->id,
            'title' => 'Ganti Thermal Paste',
            'description' => 'Hapus thermal paste lama dari CPU/GPU, oleskan thermal paste baru secara tipis dan merata.',
            'solution_type' => 'corrective',
            'order_number' => 2,
        ]);

        Solution::create([
            'diagnosis_id' => $dBattery->id,
            'title' => 'Ganti Baterai Baru',
            'description' => 'Beli baterai original atau kompatibel sesuai nomor seri laptop. Pasang dan kalibrasi ulang.',
            'solution_type' => 'corrective',
            'order_number' => 1,
        ]);

        // ── Repair Guides ────────────────────────────────────────────
        $guide1 = RepairGuide::create([
            'diagnosis_id' => $dOverheat->id,
            'title' => 'Cara Membersihkan Heatsink Laptop untuk Mengatasi Overheat',
            'description' => 'Panduan langkah demi langkah untuk membersihkan heatsink dan mengganti thermal paste laptop.',
            'difficulty' => 'medium',
            'estimated_time' => 45,
            'tools_needed' => "Obeng PH0 dan PH1\nKuas halus / blower udara\nThermal paste baru\nAlkohol isopropil 90%+\nTisu atau kain microfiber",
            'do_not_do' => "Jangan gunakan tekanan udara terlalu kencang\nJangan menyentuh komponen dengan tangan basah\nJangan membuka laptop jika masih bergaransi",
        ]);

        RepairStep::create(['repair_guide_id' => $guide1->id, 'step_number' => 1, 'title' => 'Matikan Laptop dan Lepas Baterai', 'description' => 'Matikan laptop sepenuhnya (bukan sleep/hibernate). Cabut adaptor daya. Lepas baterai jika bisa dilepas.', 'warning' => 'Pastikan laptop benar-benar mati, bukan dalam mode sleep.']);
        RepairStep::create(['repair_guide_id' => $guide1->id, 'step_number' => 2, 'title' => 'Buka Panel Bawah Laptop', 'description' => 'Lepaskan semua baut di panel bawah menggunakan obeng yang sesuai. Simpan baut di tempat aman.']);
        RepairStep::create(['repair_guide_id' => $guide1->id, 'step_number' => 3, 'title' => 'Bersihkan Debu dari Kipas dan Heatsink', 'description' => 'Gunakan kuas halus untuk menyapu debu. Arahkan blower udara dari dalam ke luar untuk mendorong debu keluar dari ventilasi.', 'warning' => 'Jangan gunakan tekanan udara terlalu kuat agar bearing kipas tidak rusak.']);
        RepairStep::create(['repair_guide_id' => $guide1->id, 'step_number' => 4, 'title' => 'Ganti Thermal Paste', 'description' => 'Lepaskan heatsink (biasanya 4 baut). Bersihkan thermal paste lama dari CPU dan heatsink menggunakan alkohol isopropil. Oleskan thermal paste baru sebesar biji jagung di tengah CPU, biarkan heatsink menyebarkannya saat dipasang.', 'warning' => 'Jangan oleskan thermal paste terlalu banyak — bisa mengalir ke komponen lain.']);
        RepairStep::create(['repair_guide_id' => $guide1->id, 'step_number' => 5, 'title' => 'Pasang Kembali dan Uji', 'description' => 'Pasang kembali heatsink, panel bawah, dan baterai. Nyalakan laptop dan cek suhu menggunakan aplikasi seperti HWiNFO64 atau Core Temp.']);

        $this->call(KnowledgeBaseSeeder::class);
    }
}
