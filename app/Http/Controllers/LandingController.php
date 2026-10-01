<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $devices = [
            ['name' => 'AC & Pendingin', 'example' => 'AC tidak dingin, bau apek', 'image' => 'ac.jpg', 'gradient' => 'linear-gradient(160deg,#0c1445 0%,#1a3a7a 100%)', 'icon' => '❄️'],
            ['name' => 'Laptop & PC', 'example' => 'Overheat, layar berkedip', 'image' => 'laptop.jpg', 'gradient' => 'linear-gradient(160deg,#0f172a 0%,#1e293b 100%)', 'icon' => '💻'],
            ['name' => 'Kulkas', 'example' => 'Tidak dingin, bunyi berisik', 'image' => 'kulkas.jpg', 'gradient' => 'linear-gradient(160deg,#064e4e 0%,#0d9488 100%)', 'icon' => '🧊'],
            ['name' => 'Mesin Cuci', 'example' => 'Bocor, tidak berputar', 'image' => 'mesin-cuci.jpg', 'gradient' => 'linear-gradient(160deg,#064e3b 0%,#059669 100%)', 'icon' => '🫧'],
            ['name' => 'Smartphone', 'example' => 'Baterai boros, layar mati', 'image' => 'smartphone.jpg', 'gradient' => 'linear-gradient(160deg,#1e1b4b 0%,#4c1d95 100%)', 'icon' => '📱'],
            ['name' => 'Listrik Rumah', 'example' => 'Sering trip, konsleting', 'image' => 'listrik.jpg', 'gradient' => 'linear-gradient(160deg,#451a03 0%,#b45309 100%)', 'icon' => '⚡'],
            ['name' => 'Kendaraan', 'example' => 'Mesin susah distarter', 'image' => 'kendaraan.jpg', 'gradient' => 'linear-gradient(160deg,#450a0a 0%,#b91c1c 100%)', 'icon' => '🚗'],
            ['name' => 'Elektronik Lainnya', 'example' => 'TV, kipas, microwave, dll.', 'image' => 'elektronik.jpg', 'gradient' => 'linear-gradient(160deg,#18181b 0%,#3f3f46 100%)', 'icon' => '🔧'],
        ];

        $features = [
            [
                'label'    => 'Diagnosis dari foto',
                'title'    => 'Unggah foto, biarkan sistem membaca kerusakannya.',
                'body'     => 'Sistem kami menganalisis bukti visual seperti retak, gosong, karat, atau kebocoran dari foto yang kamu kirim. Hasilnya bukan vonis — melainkan kemungkinan kerusakan dengan tingkat kecocokan yang transparan.',
                'note'     => 'Hasil adalah kemungkinan berdasarkan foto, bukan kepastian teknis.',
                'bg'       => 'white',
                'flip'     => false,
            ],
            [
                'label'    => 'Sistem pakar yang transparan',
                'title'    => 'Bukan kotak hitam. Setiap diagnosis punya alasan.',
                'body'     => 'FIXMET menggunakan forward chaining — mencocokkan gejala dengan aturan diagnosis satu per satu. Setiap hasil dilengkapi tombol "Mengapa?" yang menampilkan jalur logika yang diambil sistem.',
                'note'     => 'Confidence score adalah tingkat kecocokan gejala, bukan jaminan kebenaran.',
                'bg'       => 'gray',
                'flip'     => true,
            ],
            [
                'label'    => 'Panduan perbaikan langkah demi langkah',
                'title'    => 'Perbaiki sendiri — dengan panduan yang aman.',
                'body'     => 'Setiap diagnosis dilengkapi panduan perbaikan bertingkat. Label risiko LOW hingga CRITICAL membantu kamu memutuskan: bisa dikerjakan sendiri, atau perlu teknisi. Keselamatan selalu prioritas pertama.',
                'note'     => 'Untuk risiko HIGH dan CRITICAL, sistem secara aktif menyarankan teknisi terverifikasi.',
                'bg'       => 'dark',
                'flip'     => false,
            ],
        ];

        $technicians = [
            ['name' => 'Ahmad Rizki', 'specialization' => 'AC & Pendingin', 'rating' => 4.9, 'reviews' => 124, 'area' => 'Jakarta Selatan', 'fee' => 75000, 'experience' => 8, 'initial' => 'AR', 'color' => '#0071e3'],
            ['name' => 'Sari Dewi', 'specialization' => 'Laptop & Komputer', 'rating' => 4.8, 'reviews' => 89, 'area' => 'Bandung', 'fee' => 60000, 'experience' => 5, 'initial' => 'SD', 'color' => '#5856d6'],
            ['name' => 'Budi Santoso', 'specialization' => 'Elektronik Rumah', 'rating' => 4.7, 'reviews' => 201, 'area' => 'Surabaya', 'fee' => 50000, 'experience' => 10, 'initial' => 'BS', 'color' => '#34c759'],
        ];

        $stats = [
            ['label' => 'Kategori perangkat', 'value' => 10, 'suffix' => '+'],
            ['label' => 'Panduan perbaikan', 'value' => 50, 'suffix' => '+'],
            ['label' => 'Teknisi terverifikasi*', 'value' => 25, 'suffix' => '+'],
            ['label' => 'Ulasan pengguna*', 'value' => 500, 'suffix' => '+'],
        ];

        return view('landing.index', compact('devices', 'features', 'technicians', 'stats'));
    }
}
