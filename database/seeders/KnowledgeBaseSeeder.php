<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\RepairGuide;
use App\Models\Rule;
use App\Models\RuleSymptom;
use App\Models\Solution;
use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

/**
 * Expert-system knowledge for HP Android, Mesin Cuci Top Load and AC Split.
 *
 * Safe to run repeatedly: records are matched by their codes/titles and
 * updated in place, so it can be run on a database that is already seeded.
 */
class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->knowledgeBase() as $deviceName => $knowledge) {
            $device = Device::where('name', $deviceName)->firstOrFail();

            foreach ($knowledge['symptoms'] as $code => $question) {
                Symptom::updateOrCreate(
                    ['device_id' => $device->id, 'code' => $code],
                    ['question' => $question],
                );
            }

            $symptomIds = Symptom::where('device_id', $device->id)->pluck('id', 'code');

            foreach ($knowledge['diagnoses'] as $code => $definition) {
                $diagnosis = Diagnosis::updateOrCreate(
                    ['device_id' => $device->id, 'code' => $code],
                    Arr::except($definition, ['rules', 'solutions', 'guide']),
                );

                $this->seedRules($diagnosis, $definition['rules'] ?? [], $symptomIds->all());
                $this->seedSolutions($diagnosis, $definition['solutions'] ?? []);

                if (isset($definition['guide'])) {
                    $this->seedGuide($diagnosis, $definition['guide']);
                }
            }
        }
    }

    /**
     * @param  array<string, array{0: float, 1: array<string, bool>}>  $rules
     * @param  array<string, int>  $symptomIds
     */
    private function seedRules(Diagnosis $diagnosis, array $rules, array $symptomIds): void
    {
        foreach ($rules as $ruleCode => [$weight, $conditions]) {
            $rule = Rule::updateOrCreate(
                ['rule_code' => $ruleCode],
                ['diagnosis_id' => $diagnosis->id, 'confidence_weight' => $weight],
            );

            $rule->ruleSymptoms()->delete();

            foreach ($conditions as $symptomCode => $expectedAnswer) {
                RuleSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $symptomIds[$symptomCode],
                    'expected_answer' => $expectedAnswer,
                ]);
            }
        }
    }

    /**
     * @param  array<int, array{title: string, description: string, solution_type: string}>  $solutions
     */
    private function seedSolutions(Diagnosis $diagnosis, array $solutions): void
    {
        foreach ($solutions as $index => $solution) {
            Solution::updateOrCreate(
                ['diagnosis_id' => $diagnosis->id, 'title' => $solution['title']],
                [...$solution, 'order_number' => $index + 1],
            );
        }
    }

    /**
     * @param  array<string, mixed>  $guide
     */
    private function seedGuide(Diagnosis $diagnosis, array $guide): void
    {
        $repairGuide = RepairGuide::updateOrCreate(
            ['diagnosis_id' => $diagnosis->id, 'title' => $guide['title']],
            Arr::except($guide, ['title', 'steps']),
        );

        $repairGuide->steps()->delete();

        foreach ($guide['steps'] as $index => $step) {
            $repairGuide->steps()->create([...$step, 'step_number' => $index + 1]);
        }
    }

    /**
     * @return array<string, array{symptoms: array<string, string>, diagnoses: array<string, array<string, mixed>>}>
     */
    private function knowledgeBase(): array
    {
        return [
            'HP Android' => [
                'symptoms' => [
                    'H001' => 'Apakah baterai HP cepat habis walaupun jarang dipakai?',
                    'H002' => 'Apakah HP terasa panas saat mengisi daya atau saat dipakai ringan?',
                    'H003' => 'Apakah HP tidak mau mengisi daya saat charger dicolokkan?',
                    'H004' => 'Apakah kabel charger harus digoyang atau ditekan agar HP mau mengisi daya?',
                    'H005' => 'Apakah kaca layar HP retak atau pecah?',
                    'H006' => 'Apakah layar menampilkan garis, bercak hitam/warna, atau tidak merespons sentuhan di area tertentu?',
                    'H007' => 'Apakah HP pernah terkena air atau cairan lain?',
                    'H008' => 'Apakah casing belakang atau layar tampak menggembung atau terangkat?',
                    'H009' => 'Apakah HP sering restart sendiri atau tertahan di logo saat dinyalakan (bootloop)?',
                    'H010' => 'Apakah HP sangat lambat atau aplikasi sering tertutup sendiri?',
                ],
                'diagnoses' => [
                    'D-H001' => [
                        'name' => 'Baterai Aus / Kapasitas Menurun',
                        'description' => 'Sel baterai lithium sudah menurun kapasitasnya karena usia dan siklus pengisian, sehingga daya cepat habis dan baterai mudah panas.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Ganti baterai dengan yang original atau berkualitas setara di service center resmi.',
                        'danger_signs' => 'Jika HP menjadi sangat panas atau casing mulai terangkat, hentikan pengisian daya dan segera bawa ke teknisi.',
                        'rules' => [
                            'R-H001' => [0.70, ['H001' => true]],
                            'R-H001-B' => [0.80, ['H001' => true, 'H002' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Cek kesehatan baterai', 'description' => 'Buka Pengaturan > Baterai (atau gunakan kode servis bawaan merek HP) untuk melihat kondisi baterai. Kapasitas di bawah 80% menandakan baterai perlu diganti.', 'solution_type' => 'corrective'],
                            ['title' => 'Ganti baterai di service center', 'description' => 'Sebagian besar HP Android modern memakai baterai tanam yang direkatkan, sehingga penggantian sebaiknya dilakukan teknisi agar layar dan konektor tidak rusak.', 'solution_type' => 'corrective'],
                            ['title' => 'Jaga pola pengisian daya', 'description' => 'Gunakan charger original, hindari mengisi sambil bermain game berat, dan jangan biarkan HP terlalu panas saat mengisi.', 'solution_type' => 'preventive'],
                        ],
                    ],
                    'D-H002' => [
                        'name' => 'Baterai Menggembung',
                        'description' => 'Gas terbentuk di dalam sel baterai lithium sehingga baterai membengkak dan mendorong casing atau layar. Kondisi ini berisiko terbakar.',
                        'severity' => 'critical',
                        'repairability' => 'do_not_repair',
                        'recommendation' => 'Matikan HP, jangan diisi daya, dan segera bawa ke teknisi untuk penggantian baterai.',
                        'danger_signs' => 'Baterai menggembung dapat terbakar atau meledak bila ditekan, ditusuk, atau terus diisi daya.',
                        'rules' => [
                            'R-H002' => [0.90, ['H008' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Hentikan pemakaian dan pengisian daya', 'description' => 'Matikan HP dan cabut charger. Letakkan HP di permukaan yang tidak mudah terbakar, jauh dari bahan mudah terbakar.', 'solution_type' => 'emergency'],
                            ['title' => 'Jangan menekan atau membuka HP sendiri', 'description' => 'Menekan casing atau mencongkel baterai yang menggembung dapat merusak sel dan memicu api.', 'solution_type' => 'emergency'],
                            ['title' => 'Ganti baterai di teknisi', 'description' => 'Teknisi akan melepas baterai dengan aman dan memeriksa apakah layar atau komponen lain ikut rusak akibat tekanan.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-H003' => [
                        'name' => 'Port Charger Kotor / Longgar',
                        'description' => 'Debu atau serat kain menumpuk di port USB sehingga konektor tidak menempel sempurna, atau pin di dalam port mulai longgar.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Bersihkan port charger dengan alat non-logam. Jika masih longgar setelah dibersihkan, ganti board port charger di teknisi.',
                        'rules' => [
                            'R-H003' => [0.85, ['H003' => true, 'H004' => true]],
                            'R-H003-B' => [0.75, ['H004' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Bersihkan port charger', 'description' => 'Matikan HP, lalu keluarkan kotoran dari port menggunakan tusuk gigi kayu atau plastik dengan gerakan perlahan.', 'solution_type' => 'corrective'],
                            ['title' => 'Coba kabel dan kepala charger lain', 'description' => 'Pastikan masalah bukan pada kabel atau adaptor dengan mencoba charger lain yang sesuai.', 'solution_type' => 'corrective'],
                            ['title' => 'Ganti board port charger', 'description' => 'Jika port tetap longgar setelah dibersihkan, konektor atau board port perlu diganti oleh teknisi.', 'solution_type' => 'corrective'],
                        ],
                        'guide' => [
                            'title' => 'Cara Membersihkan Port Charger HP',
                            'description' => 'Langkah aman membersihkan kotoran dari port USB agar HP kembali mengisi daya dengan normal.',
                            'difficulty' => 'easy',
                            'estimated_time' => 10,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Tusuk gigi kayu atau plastik\nSenter\nKuas kecil yang kering dan bersih",
                            'do_not_do' => "Jangan gunakan jarum, peniti, atau benda logam lain\nJangan menyemprotkan air, alkohol, atau cairan apa pun ke port\nJangan membersihkan saat HP menyala atau sedang diisi daya",
                            'steps' => [
                                ['title' => 'Matikan HP', 'description' => 'Matikan HP sepenuhnya dan cabut kabel charger.', 'warning' => 'Membersihkan port saat HP menyala dapat menyebabkan korsleting pada pin.'],
                                ['title' => 'Periksa port dengan senter', 'description' => 'Arahkan senter ke dalam port untuk melihat apakah ada debu atau serat kain yang menumpuk di dasar port.'],
                                ['title' => 'Keluarkan kotoran perlahan', 'description' => 'Masukkan ujung tusuk gigi ke dasar port, lalu tarik kotoran keluar dengan gerakan mencongkel yang ringan. Ulangi sampai bersih.', 'warning' => 'Jangan menekan pin di tengah port terlalu keras.'],
                                ['title' => 'Sapu sisa debu', 'description' => 'Gunakan kuas kecil yang kering untuk menyapu sisa debu dari mulut port.'],
                                ['title' => 'Uji pengisian daya', 'description' => 'Nyalakan HP dan colokkan charger. Jika masih harus digoyang agar mengisi, port kemungkinan longgar dan perlu diganti teknisi.'],
                            ],
                        ],
                    ],
                    'D-H004' => [
                        'name' => 'Kerusakan IC Charging / Jalur Pengisian Daya',
                        'description' => 'HP tidak mengisi daya sama sekali walaupun konektor terpasang dengan baik. Penyebabnya bisa IC pengisian daya, konektor baterai, atau baterai yang mati total.',
                        'severity' => 'high',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Bawa ke teknisi untuk pengukuran arus pengisian dan pemeriksaan IC charging serta baterai.',
                        'rules' => [
                            'R-H004' => [0.70, ['H003' => true, 'H004' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Pastikan charger berfungsi', 'description' => 'Coba charger dan kabel lain yang diketahui normal sebelum membawa HP ke teknisi.', 'solution_type' => 'corrective'],
                            ['title' => 'Pemeriksaan jalur pengisian oleh teknisi', 'description' => 'Teknisi akan mengukur arus masuk dengan USB tester untuk menentukan apakah kerusakan ada di IC charging, konektor baterai, atau baterai.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-H005' => [
                        'name' => 'Layar Pecah / LCD Rusak',
                        'description' => 'Kaca pelindung atau panel LCD/OLED rusak akibat benturan atau tekanan, sehingga muncul retakan, garis, bercak, atau area yang tidak merespons sentuhan.',
                        'severity' => 'high',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Ganti modul layar (LCD + touchscreen) di service center.',
                        'danger_signs' => 'Serpihan kaca dapat melukai jari. Jika layar menghitam total disertai panas, matikan HP.',
                        'rules' => [
                            'R-H005' => [0.90, ['H005' => true]],
                            'R-H005-B' => [0.80, ['H006' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Lindungi layar sementara', 'description' => 'Tempelkan pelindung layar atau selotip bening di atas retakan agar serpihan kaca tidak melukai jari.', 'solution_type' => 'emergency'],
                            ['title' => 'Cadangkan data', 'description' => 'Selama layar masih bisa dipakai, segera cadangkan foto dan data penting ke cloud atau komputer.', 'solution_type' => 'emergency'],
                            ['title' => 'Ganti modul layar', 'description' => 'Penggantian layar membutuhkan alat pemanas dan perekat khusus, sebaiknya dilakukan di service center.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-H006' => [
                        'name' => 'Kerusakan Akibat Cairan',
                        'description' => 'Cairan yang masuk ke dalam HP dapat menyebabkan korsleting dan korosi pada papan sirkuit, yang sering baru terlihat beberapa hari kemudian.',
                        'severity' => 'high',
                        'repairability' => 'do_not_repair',
                        'recommendation' => 'Segera matikan HP, jangan diisi daya, dan bawa ke teknisi untuk pembersihan papan sirkuit secepatnya.',
                        'danger_signs' => 'Jangan menyalakan atau mengisi daya HP yang masih basah karena dapat menyebabkan korsleting permanen.',
                        'rules' => [
                            'R-H006' => [0.85, ['H007' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Matikan HP segera', 'description' => 'Matikan HP, lepaskan casing, kartu SIM, dan kartu memori. Jangan menekan tombol berulang kali.', 'solution_type' => 'emergency'],
                            ['title' => 'Jangan isi daya dan jangan dikeringkan dengan panas', 'description' => 'Hindari hair dryer atau menjemur di bawah matahari, karena panas dapat merusak komponen dan mendorong cairan lebih dalam.', 'solution_type' => 'emergency'],
                            ['title' => 'Bawa ke teknisi untuk pembersihan', 'description' => 'Teknisi akan membuka HP dan membersihkan papan sirkuit dengan cairan khusus untuk menghentikan korosi.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-H007' => [
                        'name' => 'Gangguan Sistem / Software',
                        'description' => 'Sistem operasi atau aplikasi bermasalah karena memori penuh, pembaruan yang gagal, atau aplikasi yang tidak kompatibel.',
                        'severity' => 'medium',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Kosongkan memori, hapus aplikasi bermasalah lewat Safe Mode, dan lakukan reset pabrik bila perlu setelah mencadangkan data.',
                        'rules' => [
                            'R-H007' => [0.70, ['H010' => true, 'H007' => false]],
                            'R-H007-B' => [0.75, ['H009' => true, 'H007' => false, 'H008' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Kosongkan penyimpanan', 'description' => 'Pastikan sisa penyimpanan minimal 10–15%. Hapus file besar, cache aplikasi, dan aplikasi yang tidak dipakai.', 'solution_type' => 'corrective'],
                            ['title' => 'Cek aplikasi bermasalah lewat Safe Mode', 'description' => 'Jika HP normal di Safe Mode, penyebabnya adalah aplikasi pihak ketiga yang baru dipasang.', 'solution_type' => 'corrective'],
                            ['title' => 'Reset pabrik', 'description' => 'Jika masalah tetap ada, cadangkan data lalu lakukan reset pabrik. Bila bootloop berlanjut setelah reset, bawa ke teknisi untuk flashing ulang.', 'solution_type' => 'corrective'],
                        ],
                        'guide' => [
                            'title' => 'Mengatasi HP Lambat, Sering Restart, atau Bootloop',
                            'description' => 'Langkah bertahap dari yang paling ringan sampai reset pabrik untuk memperbaiki gangguan software pada HP Android.',
                            'difficulty' => 'medium',
                            'estimated_time' => 60,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Charger HP\nAkun Google dan kata sandinya\nKomputer atau penyimpanan cloud untuk cadangan data",
                            'do_not_do' => "Jangan reset pabrik sebelum mencadangkan data\nJangan reset jika lupa kata sandi akun Google (HP bisa terkunci FRP)\nJangan memasang ROM atau aplikasi dari sumber tidak resmi",
                            'steps' => [
                                ['title' => 'Isi daya minimal 50%', 'description' => 'Pastikan baterai cukup agar HP tidak mati di tengah proses.'],
                                ['title' => 'Restart dan kosongkan penyimpanan', 'description' => 'Restart HP, lalu buka Pengaturan > Penyimpanan. Hapus file besar dan aplikasi yang tidak dipakai sampai sisa penyimpanan di atas 10%.'],
                                ['title' => 'Masuk Safe Mode', 'description' => 'Tekan lama tombol power, lalu tekan lama opsi "Matikan" sampai muncul "Safe Mode". Jika HP normal di Safe Mode, hapus aplikasi yang terakhir dipasang satu per satu.'],
                                ['title' => 'Perbarui sistem dan aplikasi', 'description' => 'Pasang pembaruan sistem di Pengaturan > Pembaruan Perangkat Lunak dan perbarui aplikasi di Play Store.'],
                                ['title' => 'Cadangkan data', 'description' => 'Cadangkan foto, kontak, dan chat ke akun Google atau komputer sebelum melakukan reset.', 'warning' => 'Reset pabrik menghapus semua data di memori internal.'],
                                ['title' => 'Reset pabrik', 'description' => 'Buka Pengaturan > Sistem > Reset > Hapus semua data. Jika HP bootloop dan tidak bisa masuk pengaturan, reset melalui Recovery Mode (kombinasi tombol berbeda tiap merek).', 'warning' => 'Pastikan Anda ingat akun Google yang terdaftar di HP.'],
                                ['title' => 'Bawa ke teknisi bila masih bermasalah', 'description' => 'Jika bootloop tetap terjadi setelah reset, kemungkinan perlu flashing firmware atau ada kerusakan memori internal.'],
                            ],
                        ],
                    ],
                ],
            ],

            'Mesin Cuci Top Load' => [
                'symptoms' => [
                    'M001' => 'Apakah mesin cuci tidak menyala sama sekali saat tombol power ditekan?',
                    'M002' => 'Apakah tabung tidak berputar saat mencuci padahal air sudah masuk?',
                    'M003' => 'Apakah air tidak masuk ke tabung atau masuk sangat lambat?',
                    'M004' => 'Apakah air tidak terbuang atau masih menggenang setelah siklus selesai?',
                    'M005' => 'Apakah ada air bocor atau menggenang di lantai di bawah mesin?',
                    'M006' => 'Apakah mesin bergetar sangat keras atau bergeser saat proses pengeringan (spin)?',
                    'M007' => 'Apakah terdengar bunyi gemuruh, berderit, atau gesekan keras saat tabung berputar?',
                    'M008' => 'Apakah tercium bau hangus atau terlihat bekas gosong pada kabel atau stop kontak?',
                    'M009' => 'Apakah pakaian masih sangat basah setelah proses pengeringan (spin)?',
                    'M010' => 'Apakah muncul kode error atau lampu indikator berkedip di panel?',
                ],
                'diagnoses' => [
                    'D-M001' => [
                        'name' => 'Saluran Pembuangan Tersumbat',
                        'description' => 'Selang atau filter pembuangan tersumbat serat kain, koin, atau kotoran sehingga air tidak bisa keluar dan proses spin tidak berjalan sempurna.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Bersihkan filter serabut dan selang pembuangan.',
                        'rules' => [
                            'R-M001' => [0.85, ['M004' => true]],
                            'R-M001-B' => [0.80, ['M004' => true, 'M009' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Bersihkan filter serabut', 'description' => 'Lepas dan cuci filter serabut (lint filter) di dalam tabung dengan air mengalir.', 'solution_type' => 'corrective'],
                            ['title' => 'Periksa selang pembuangan', 'description' => 'Pastikan selang tidak tertekuk, tertindih, atau tersumbat, dan ujungnya tidak terendam air di saluran.', 'solution_type' => 'corrective'],
                            ['title' => 'Kosongkan saku pakaian sebelum mencuci', 'description' => 'Koin, tisu, dan benda kecil adalah penyebab utama saluran tersumbat.', 'solution_type' => 'preventive'],
                        ],
                        'guide' => [
                            'title' => 'Cara Membersihkan Saluran Pembuangan Mesin Cuci Top Load',
                            'description' => 'Membersihkan filter serabut dan selang pembuangan agar air kembali terbuang lancar.',
                            'difficulty' => 'easy',
                            'estimated_time' => 30,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Ember dan kain lap\nSikat kecil\nObeng (jika klem selang perlu dilepas)",
                            'do_not_do' => "Jangan bekerja saat mesin masih tersambung listrik\nJangan memaksa selang yang getas karena bisa retak\nJangan memakai cairan pembersih saluran yang korosif",
                            'steps' => [
                                ['title' => 'Cabut kabel listrik', 'description' => 'Matikan mesin dan cabut steker dari stop kontak.', 'warning' => 'Air dan listrik berbahaya. Pastikan tangan kering saat mencabut steker.'],
                                ['title' => 'Buang sisa air', 'description' => 'Turunkan ujung selang pembuangan ke ember di lantai agar sisa air keluar.'],
                                ['title' => 'Bersihkan filter serabut', 'description' => 'Lepas filter serabut di dinding tabung, buang kotorannya, lalu cuci dengan sikat dan air mengalir.'],
                                ['title' => 'Periksa selang pembuangan', 'description' => 'Lepas selang dari mesin bila perlu, keluarkan sumbatan, lalu bilas sampai air mengalir lancar.'],
                                ['title' => 'Pasang kembali dan uji', 'description' => 'Pasang filter dan selang, pastikan klem kencang, lalu jalankan program bilas singkat tanpa pakaian untuk memastikan air terbuang.'],
                            ],
                        ],
                    ],
                    'D-M002' => [
                        'name' => 'Saringan Air Masuk Tersumbat / Katup Inlet Bermasalah',
                        'description' => 'Saringan kecil di sambungan selang air masuk tersumbat kotoran atau kerak, atau katup inlet (solenoid valve) tidak membuka.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Pastikan keran terbuka dan tekanan air cukup, lalu bersihkan saringan inlet. Jika air tetap tidak masuk, katup inlet perlu diganti teknisi.',
                        'rules' => [
                            'R-M002' => [0.80, ['M003' => true, 'M001' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Periksa keran dan tekanan air', 'description' => 'Pastikan keran terbuka penuh dan air PAM atau pompa mengalir normal di keran lain.', 'solution_type' => 'corrective'],
                            ['title' => 'Bersihkan saringan inlet', 'description' => 'Lepas selang air masuk dari mesin dan bersihkan saringan kecil di dalam lubang sambungan.', 'solution_type' => 'corrective'],
                            ['title' => 'Ganti katup inlet', 'description' => 'Jika saringan bersih tetapi air tetap tidak masuk, katup solenoid inlet kemungkinan rusak dan perlu diganti teknisi.', 'solution_type' => 'corrective'],
                        ],
                        'guide' => [
                            'title' => 'Cara Membersihkan Saringan Air Masuk Mesin Cuci',
                            'description' => 'Membersihkan saringan inlet yang tersumbat agar air kembali masuk dengan lancar.',
                            'difficulty' => 'easy',
                            'estimated_time' => 20,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Tang kecil atau pinset\nSikat gigi bekas\nKain lap",
                            'do_not_do' => "Jangan melepas selang sebelum keran ditutup\nJangan merusak jaring saringan saat mencabutnya\nJangan menjalankan mesin tanpa saringan terpasang",
                            'steps' => [
                                ['title' => 'Cabut listrik dan tutup keran', 'description' => 'Cabut steker mesin dan tutup keran air yang tersambung ke mesin.', 'warning' => 'Selalu putus aliran listrik sebelum bekerja di dekat air.'],
                                ['title' => 'Lepas selang air masuk', 'description' => 'Putar sambungan selang di bagian belakang atau atas mesin. Siapkan kain untuk menampung sisa air.'],
                                ['title' => 'Keluarkan dan bersihkan saringan', 'description' => 'Tarik saringan kecil di lubang sambungan dengan tang atau pinset, lalu sikat sampai kotoran dan kerak hilang.'],
                                ['title' => 'Pasang kembali dan uji', 'description' => 'Pasang saringan dan selang, buka keran, periksa tidak ada rembesan, lalu jalankan program cuci singkat.'],
                            ],
                        ],
                    ],
                    'D-M003' => [
                        'name' => 'Beban Tidak Seimbang / Posisi Mesin Tidak Rata',
                        'description' => 'Cucian menumpuk di satu sisi tabung atau kaki mesin tidak rata, sehingga mesin bergetar keras dan bergeser saat spin.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Ratakan posisi cucian, kurangi beban berlebih, dan pastikan mesin berdiri di lantai yang datar.',
                        'rules' => [
                            'R-M003' => [0.75, ['M006' => true, 'M007' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Ratakan cucian di tabung', 'description' => 'Hentikan mesin, sebarkan cucian merata mengelilingi tabung, lalu lanjutkan spin.', 'solution_type' => 'corrective'],
                            ['title' => 'Datarkan posisi mesin', 'description' => 'Letakkan mesin di lantai datar dan atur kaki mesin sampai tidak goyang.', 'solution_type' => 'corrective'],
                            ['title' => 'Jangan melebihi kapasitas', 'description' => 'Isi cucian sesuai kapasitas mesin. Cuci barang besar seperti selimut secara terpisah.', 'solution_type' => 'preventive'],
                        ],
                        'guide' => [
                            'title' => 'Cara Mengatasi Mesin Cuci Bergetar Keras',
                            'description' => 'Mengatur posisi cucian dan kaki mesin agar getaran saat spin kembali normal.',
                            'difficulty' => 'easy',
                            'estimated_time' => 15,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Waterpass (atau aplikasi waterpass di HP)\nKunci pas untuk kaki mesin (jika ada)",
                            'do_not_do' => "Jangan menahan mesin dengan tangan saat sedang spin\nJangan mengganjal kaki mesin dengan benda licin atau mudah bergeser",
                            'steps' => [
                                ['title' => 'Hentikan mesin', 'description' => 'Tekan tombol pause atau matikan mesin dan tunggu tabung berhenti total.', 'warning' => 'Jangan membuka tutup saat tabung masih berputar.'],
                                ['title' => 'Ratakan cucian', 'description' => 'Sebarkan cucian merata di sekeliling tabung. Keluarkan sebagian bila terlalu penuh.'],
                                ['title' => 'Periksa kerataan lantai', 'description' => 'Letakkan waterpass di atas mesin. Atur kaki mesin yang bisa diputar sampai mesin rata dan tidak goyang saat ditekan di tiap sudut.'],
                                ['title' => 'Uji dengan spin', 'description' => 'Jalankan program spin. Jika getaran tetap sangat keras disertai bunyi gesekan, hubungi teknisi untuk memeriksa peredam dan bearing.'],
                            ],
                        ],
                    ],
                    'D-M004' => [
                        'name' => 'V-Belt Kendur/Putus atau Pulley Aus',
                        'description' => 'Sabuk penggerak (V-belt) yang menghubungkan motor ke tabung kendur, aus, atau putus, sehingga motor berbunyi tetapi tabung tidak berputar.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Bawa ke teknisi untuk pemeriksaan dan penggantian V-belt atau pulley.',
                        'rules' => [
                            'R-M004' => [0.80, ['M002' => true, 'M001' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Hentikan pemakaian', 'description' => 'Menjalankan motor terus-menerus tanpa beban yang berputar dapat membuat motor panas.', 'solution_type' => 'emergency'],
                            ['title' => 'Ganti V-belt di teknisi', 'description' => 'Penggantian V-belt memerlukan pembongkaran bagian bawah mesin dan penyetelan ketegangan yang tepat.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-M005' => [
                        'name' => 'Bearing / Gearbox Aus',
                        'description' => 'Bantalan (bearing) atau gearbox di bawah tabung aus sehingga timbul bunyi gemuruh atau gesekan keras saat tabung berputar.',
                        'severity' => 'high',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Hentikan pemakaian dan bawa ke teknisi untuk penggantian bearing atau gearbox.',
                        'danger_signs' => 'Bearing yang dibiarkan rusak dapat merusak poros dan tabung, sehingga biaya perbaikan menjadi jauh lebih mahal.',
                        'rules' => [
                            'R-M005' => [0.75, ['M007' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Kurangi pemakaian', 'description' => 'Hentikan pemakaian sampai mesin diperiksa agar kerusakan tidak menjalar ke poros dan tabung.', 'solution_type' => 'emergency'],
                            ['title' => 'Ganti bearing atau gearbox di teknisi', 'description' => 'Pekerjaan ini memerlukan pembongkaran tabung dan alat khusus.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-M006' => [
                        'name' => 'Kebocoran Selang atau Seal',
                        'description' => 'Air merembes dari sambungan selang yang longgar, selang yang retak, atau seal di bawah tabung yang sudah getas.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Periksa dan kencangkan sambungan selang. Jika bocor berasal dari bawah tabung, panggil teknisi untuk mengganti seal.',
                        'danger_signs' => 'Genangan air di dekat stop kontak dan kabel berisiko menimbulkan sengatan listrik.',
                        'rules' => [
                            'R-M006' => [0.80, ['M005' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Cabut listrik dan keringkan lantai', 'description' => 'Cabut steker dan keringkan genangan sebelum memeriksa sumber kebocoran.', 'solution_type' => 'emergency'],
                            ['title' => 'Kencangkan sambungan selang', 'description' => 'Periksa sambungan selang air masuk dan pembuangan. Kencangkan klem atau ganti selang yang retak.', 'solution_type' => 'corrective'],
                            ['title' => 'Ganti seal oleh teknisi', 'description' => 'Kebocoran dari bagian bawah tabung biasanya berasal dari seal atau kran pembuangan internal yang perlu diganti teknisi.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-M007' => [
                        'name' => 'Korsleting / Gangguan Kelistrikan',
                        'description' => 'Ada kabel, stop kontak, atau komponen listrik yang terbakar atau terhubung singkat. Kondisi ini berisiko kebakaran dan sengatan listrik.',
                        'severity' => 'critical',
                        'repairability' => 'do_not_repair',
                        'recommendation' => 'Segera cabut steker atau matikan MCB, jangan gunakan mesin, dan hubungi teknisi listrik.',
                        'danger_signs' => 'Bau hangus dan bekas gosong adalah tanda bahaya kebakaran. Jangan menyentuh mesin dengan tangan basah.',
                        'rules' => [
                            'R-M007' => [0.95, ['M008' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Putus aliran listrik', 'description' => 'Cabut steker jika aman, atau matikan MCB rumah bila stop kontak terlihat gosong.', 'solution_type' => 'emergency'],
                            ['title' => 'Jangan gunakan mesin', 'description' => 'Jangan menyalakan kembali mesin sebelum diperiksa teknisi.', 'solution_type' => 'emergency'],
                            ['title' => 'Pemeriksaan oleh teknisi', 'description' => 'Teknisi akan memeriksa kabel daya, stop kontak, motor, dan modul kontrol untuk menemukan titik korsleting.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-M008' => [
                        'name' => 'Tidak Ada Daya / Modul Kontrol (PCB) Bermasalah',
                        'description' => 'Mesin tidak menyala karena tidak ada aliran listrik, sekring putus, atau modul kontrol (PCB) rusak.',
                        'severity' => 'high',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Periksa stop kontak dan MCB terlebih dahulu. Jika listrik normal tetapi mesin tetap mati, bawa ke teknisi untuk pemeriksaan PCB.',
                        'rules' => [
                            'R-M008' => [0.70, ['M001' => true, 'M008' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Periksa sumber listrik', 'description' => 'Colokkan perangkat lain ke stop kontak yang sama dan pastikan MCB tidak turun.', 'solution_type' => 'corrective'],
                            ['title' => 'Pemeriksaan PCB oleh teknisi', 'description' => 'Teknisi akan mengecek sekring, kabel daya, dan modul kontrol.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-M009' => [
                        'name' => 'Spin Lemah: Kopling/Rem Spin atau Motor Bermasalah',
                        'description' => 'Air sudah terbuang tetapi putaran spin terlalu lemah sehingga pakaian tetap basah. Penyebabnya bisa kopling, rem spin, atau motor yang melemah.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Pastikan beban tidak berlebih. Jika spin tetap lemah, bawa ke teknisi untuk memeriksa kopling dan motor.',
                        'rules' => [
                            'R-M009' => [0.70, ['M009' => true, 'M004' => false]],
                        ],
                        'solutions' => [
                            ['title' => 'Kurangi beban cucian', 'description' => 'Coba proses spin dengan beban lebih sedikit untuk memastikan masalah bukan karena kelebihan muatan.', 'solution_type' => 'corrective'],
                            ['title' => 'Pemeriksaan kopling dan motor', 'description' => 'Teknisi akan memeriksa kopling, rem spin, kapasitor, dan motor.', 'solution_type' => 'corrective'],
                        ],
                    ],
                ],
            ],

            'AC Split' => [
                'symptoms' => [],
                'diagnoses' => [
                    'D-A001' => [
                        'name' => 'Freon Habis / Bocor',
                        'description' => 'Refrigerant (freon) AC habis atau bocor sehingga AC tidak dingin.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Isi ulang freon dan perbaiki kebocoran jika ada.',
                        'solutions' => [
                            ['title' => 'Matikan AC jika muncul bunga es', 'description' => 'Bunga es pada pipa atau evaporator menandakan tekanan freon rendah. Matikan AC agar kompresor tidak bekerja terlalu berat.', 'solution_type' => 'emergency'],
                            ['title' => 'Cari dan tambal kebocoran', 'description' => 'Teknisi akan memeriksa sambungan pipa (flare) dan evaporator dengan busa sabun atau detektor kebocoran sebelum mengisi freon.', 'solution_type' => 'corrective'],
                            ['title' => 'Isi ulang freon sesuai tipe', 'description' => 'Pengisian harus memakai jenis freon yang sesuai label unit (R32, R410A, atau R22) dan diukur dengan manifold gauge. Jangan mengisi freon sendiri.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-A002' => [
                        'name' => 'AC Kotor / Filter Tersumbat',
                        'description' => 'Filter dan evaporator AC sangat kotor sehingga menghambat aliran udara.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Cuci filter dan bersihkan unit indoor secara berkala.',
                        'solutions' => [
                            ['title' => 'Cuci filter udara', 'description' => 'Lepas filter di balik panel depan unit indoor, cuci dengan air mengalir, lalu keringkan di tempat teduh sebelum dipasang kembali.', 'solution_type' => 'corrective'],
                            ['title' => 'Servis cuci AC menyeluruh', 'description' => 'Jika setelah filter dicuci AC masih bau atau kurang dingin, lakukan cuci evaporator dan blower oleh teknisi.', 'solution_type' => 'corrective'],
                            ['title' => 'Bersihkan filter rutin', 'description' => 'Cuci filter setiap 2–4 minggu dan lakukan servis cuci AC setiap 3–4 bulan.', 'solution_type' => 'preventive'],
                        ],
                        'guide' => [
                            'title' => 'Cara Membersihkan Filter dan Unit Indoor AC Split',
                            'description' => 'Perawatan mandiri untuk mengembalikan aliran udara dingin dan menghilangkan bau apek.',
                            'difficulty' => 'easy',
                            'estimated_time' => 30,
                            'cost_range' => 'Rp0 – Rp50.000',
                            'tools_needed' => "Kain lap dan ember\nSikat lembut\nSemprotan pembersih evaporator (opsional)\nTangga yang stabil",
                            'do_not_do' => "Jangan membersihkan saat AC masih tersambung listrik\nJangan menyemprot air ke bagian panel listrik atau PCB\nJangan menyikat sirip evaporator terlalu keras karena mudah bengkok\nJangan menjemur filter di bawah matahari langsung",
                            'steps' => [
                                ['title' => 'Matikan AC dan putus listrik', 'description' => 'Matikan AC dengan remote, lalu cabut steker atau matikan MCB khusus AC.', 'warning' => 'Pastikan listrik benar-benar terputus sebelum membuka panel.'],
                                ['title' => 'Buka panel depan dan lepas filter', 'description' => 'Angkat panel depan unit indoor, lalu tarik filter udara ke bawah secara perlahan.'],
                                ['title' => 'Cuci filter', 'description' => 'Bilas filter dengan air mengalir dari sisi belakang, sikat lembut debu yang menempel, lalu keringkan di tempat teduh.'],
                                ['title' => 'Bersihkan sirip evaporator', 'description' => 'Sapu debu di sirip evaporator dengan sikat lembut searah sirip. Gunakan semprotan pembersih evaporator bila tersedia.', 'warning' => 'Lindungi bagian panel listrik di sisi kanan unit agar tidak terkena cairan.'],
                                ['title' => 'Pasang kembali dan uji', 'description' => 'Pasang filter yang sudah kering dan tutup panel. Nyalakan AC dan rasakan apakah udara lebih dingin dan tidak berbau.'],
                            ],
                        ],
                    ],
                    'D-A003' => [
                        'name' => 'Saluran Pembuangan Air (Drain) Tersumbat',
                        'description' => 'Selang atau bak penampung air kondensasi tersumbat lumpur atau lumut, sehingga air meluap dan menetes dari unit indoor.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Bersihkan selang pembuangan dan bak penampung air di unit indoor.',
                        'rules' => [
                            'R-A003' => [0.80, ['A002' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Bersihkan selang pembuangan', 'description' => 'Tiup atau sedot ujung selang pembuangan di luar ruangan untuk mengeluarkan lumpur dan lumut.', 'solution_type' => 'corrective'],
                            ['title' => 'Periksa kemiringan selang', 'description' => 'Pastikan selang pembuangan menurun tanpa tertekuk, sehingga air bisa mengalir keluar.', 'solution_type' => 'corrective'],
                            ['title' => 'Servis AC berkala', 'description' => 'Lumut di bak penampung dapat dicegah dengan servis cuci AC setiap 3–4 bulan.', 'solution_type' => 'preventive'],
                        ],
                        'guide' => [
                            'title' => 'Cara Mengatasi AC Split Menetes Air',
                            'description' => 'Membersihkan selang dan bak pembuangan agar air kondensasi tidak meluap ke dalam ruangan.',
                            'difficulty' => 'easy',
                            'estimated_time' => 30,
                            'cost_range' => 'Rp0',
                            'tools_needed' => "Ember dan kain lap\nSelang air atau botol semprot\nKawat lentur yang ujungnya dibungkus kain (opsional)",
                            'do_not_do' => "Jangan bekerja saat AC masih tersambung listrik\nJangan menusuk selang dengan benda tajam\nJangan menuang air ke unit indoor terlalu banyak sekaligus",
                            'steps' => [
                                ['title' => 'Matikan AC dan putus listrik', 'description' => 'Matikan AC dan cabut steker atau turunkan MCB khusus AC.', 'warning' => 'Air yang menetes di dekat stop kontak dapat menyebabkan korsleting.'],
                                ['title' => 'Temukan ujung selang pembuangan', 'description' => 'Ikuti selang kecil dari unit indoor sampai ujungnya di luar ruangan atau di saluran air.'],
                                ['title' => 'Keluarkan sumbatan', 'description' => 'Tiup atau sedot ujung selang, atau dorong perlahan dengan kawat lentur berlapis kain, sampai lumpur keluar.'],
                                ['title' => 'Uji aliran air', 'description' => 'Buka panel depan, tuang segelas air perlahan ke bak penampung di bawah evaporator, dan pastikan air keluar dari ujung selang.'],
                                ['title' => 'Nyalakan kembali AC', 'description' => 'Pasang panel, sambungkan listrik, dan amati selama 30 menit apakah masih ada tetesan.'],
                            ],
                        ],
                    ],
                    'D-A004' => [
                        'name' => 'Kipas, Motor Fan, atau Kompresor Bermasalah',
                        'description' => 'Bunyi gemeretak atau dengung keras berasal dari baling-baling kipas yang longgar atau kotor, bearing motor fan yang aus, atau kompresor yang bekerja tidak normal.',
                        'severity' => 'medium',
                        'repairability' => 'professional_only',
                        'recommendation' => 'Matikan AC jika bunyi sangat keras dan hubungi teknisi untuk memeriksa motor fan dan kompresor.',
                        'rules' => [
                            'R-A004' => [0.75, ['A004' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Periksa benda asing', 'description' => 'Pastikan tidak ada benda atau ranting yang mengenai kipas unit outdoor.', 'solution_type' => 'corrective'],
                            ['title' => 'Pemeriksaan motor fan dan kompresor', 'description' => 'Teknisi akan memeriksa bearing motor fan, baut dudukan, dan kondisi kompresor.', 'solution_type' => 'corrective'],
                        ],
                    ],
                    'D-A005' => [
                        'name' => 'Remote AC Bermasalah',
                        'description' => 'Remote tidak mengirim sinyal karena baterai lemah, kontak baterai berkarat, atau sensor penerima di unit indoor tertutup.',
                        'severity' => 'low',
                        'repairability' => 'self_repair',
                        'recommendation' => 'Ganti baterai remote dan bersihkan kontak baterai. Jika tetap tidak berfungsi, gunakan remote pengganti yang kompatibel.',
                        'rules' => [
                            'R-A005' => [0.85, ['A005' => true]],
                        ],
                        'solutions' => [
                            ['title' => 'Ganti baterai remote', 'description' => 'Pasang baterai baru dan bersihkan kontak baterai yang berkarat dengan kain kering.', 'solution_type' => 'corrective'],
                            ['title' => 'Uji sinyal inframerah', 'description' => 'Arahkan remote ke kamera HP lalu tekan tombol. Jika tidak terlihat cahaya berkedip di layar kamera, remote rusak.', 'solution_type' => 'corrective'],
                            ['title' => 'Nyalakan AC dari tombol darurat', 'description' => 'Sebagian besar unit indoor punya tombol darurat (auto/emergency) di balik panel depan untuk menyalakan AC tanpa remote.', 'solution_type' => 'emergency'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
