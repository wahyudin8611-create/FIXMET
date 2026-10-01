@extends('layouts.app')
@section('title', 'Cara Kerja FIXMATE')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Cara Kerja FIXMATE</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Dari diagnosis AI hingga teknisi tiba di depan pintu Anda</p>
    </div>

    {{-- Steps --}}
    <div class="space-y-8 mb-14">
        @foreach([
            ['01', 'Unggah Foto & Pilih Perangkat', 'Foto kerusakan perangkat Anda dan pilih kategori yang sesuai. Sistem kami akan membantu mengidentifikasi jenis kerusakan secara visual.', 'blue'],
            ['02', 'Jawab Pertanyaan Diagnosis', 'Sistem pakar kami akan mengajukan serangkaian pertanyaan Ya/Tidak tentang gejala yang dialami. Semakin akurat jawaban Anda, semakin tepat diagnosisnya.', 'purple'],
            ['03', 'Terima Hasil Diagnosis AI', 'Dapatkan diagnosis lengkap dengan tingkat kepercayaan (confidence), tingkat keparahan, dan solusi yang direkomendasikan.', 'green'],
            ['04', 'Pilih Tindakan Selanjutnya', 'Ikuti panduan perbaikan mandiri ATAU temukan teknisi profesional terverifikasi di area Anda untuk perbaikan yang lebih kompleks.', 'orange'],
            ['05', 'Booking & Perbaikan', 'Hubungi teknisi pilihan Anda, komunikasikan masalah lewat chat, dan jadwalkan kunjungan perbaikan sesuai waktu Anda.', 'red'],
        ] as [$num, $title, $desc, $color])
        <div class="flex gap-5">
            <div class="flex-shrink-0 w-12 h-12 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-full flex items-center justify-center font-bold text-lg">{{ $num }}</div>
            <div class="pt-1">
                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $title }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-gray-50 rounded-2xl p-8 mb-10">
        <h2 class="text-xl font-bold text-gray-900 text-center mb-6">Keunggulan Sistem Pakar FIXMATE</h2>
        <div class="grid md:grid-cols-2 gap-5">
            @foreach([
                ['Forward Chaining', 'Proses penalaran dari fakta (gejala) menuju kesimpulan (diagnosis), sama seperti cara dokter mendiagnosis pasien.'],
                ['AND Logic', 'Semua kondisi aturan harus terpenuhi. Tidak ada "tebakan" — hanya diagnosis yang memiliki cukup bukti yang ditampilkan.'],
                ['Confidence Score', 'Setiap hasil dilengkapi persentase keyakinan, sehingga Anda tahu seberapa pasti diagnosisnya.'],
                ['Safety First', 'Untuk kerusakan kritis, sistem otomatis menonaktifkan panduan mandiri dan mewajibkan teknisi profesional.'],
            ] as [$title, $desc])
            <div class="flex gap-3">
                <span class="text-green-500 mt-0.5">✓</span>
                <div>
                    <span class="font-semibold text-gray-900">{{ $title }}</span>
                    <p class="text-gray-600 text-sm mt-0.5">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('diagnosis.create') }}" class="inline-block bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-700">
            Mulai Diagnosis Sekarang
        </a>
    </div>
</div>
@endsection
