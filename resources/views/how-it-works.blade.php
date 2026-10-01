@extends('layouts.app')
@section('title', 'Cara Kerja FIXMET')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-16">

    {{-- Header --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-fm-primary/5 border border-fm-primary/10 mb-7">
            <span class="w-1.5 h-1.5 rounded-full bg-fm-primary animate-pulse"></span>
            <span class="eyebrow text-fm-primary">Cara Kerja</span>
        </div>
        <h1 class="display-xl text-fm-dark mb-5" style="font-size:clamp(2.25rem,5vw,3rem);">Cara Kerja FIXMET</h1>
        <p class="body-lg max-w-xl mx-auto">Dari diagnosis hingga teknisi tiba di depan pintu Anda</p>
    </div>

    {{-- Steps --}}
    <div class="space-y-6 mb-16">
        @php
            $colors = ['#3D8B7A', '#2A6356', '#5BA897', '#E2B85B', '#D4A63E'];
        @endphp
        @foreach([
            ['01', 'Unggah Foto & Pilih Perangkat', 'Foto kerusakan perangkat Anda dan pilih kategori yang sesuai. Sistem kami akan membantu mengidentifikasi jenis kerusakan secara visual.'],
            ['02', 'Jawab Pertanyaan Diagnosis', 'Sistem pakar kami akan mengajukan serangkaian pertanyaan Ya/Tidak tentang gejala yang dialami. Semakin akurat jawaban Anda, semakin tepat diagnosisnya.'],
            ['03', 'Terima Hasil Diagnosis', 'Dapatkan diagnosis lengkap dengan tingkat kepercayaan (confidence), tingkat keparahan, dan solusi yang direkomendasikan.'],
            ['04', 'Pilih Tindakan Selanjutnya', 'Ikuti panduan perbaikan mandiri ATAU temukan teknisi profesional terverifikasi di area Anda untuk perbaikan yang lebih kompleks.'],
            ['05', 'Booking & Perbaikan', 'Hubungi teknisi pilihan Anda, komunikasikan masalah lewat chat, dan jadwalkan kunjungan perbaikan sesuai waktu Anda.'],
        ] as $idx => [$num, $title, $desc])
        <div class="flex gap-5 bg-white rounded-2xl p-6 border border-black/[.04] shadow-sm">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-white text-sm" style="background: {{ $colors[$idx] }};">{{ $num }}</div>
            <div class="pt-0.5">
                <h3 class="font-bold text-fm-dark mb-1.5" style="font-size:1.0625rem;letter-spacing:-.02em;">{{ $title }}</h3>
                <p class="body-md">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Keunggulan --}}
    <div class="bg-fm-primary/[.04] rounded-3xl p-8 sm:p-12 mb-16 border border-fm-primary/[.08]">
        <h2 class="display-md text-fm-dark text-center mb-8" style="font-size:1.5rem;">Keunggulan Sistem Pakar FIXMET</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach([
                ['Forward Chaining', 'Proses penalaran dari fakta (gejala) menuju kesimpulan (diagnosis), sama seperti cara dokter mendiagnosis pasien.'],
                ['AND Logic', 'Semua kondisi aturan harus terpenuhi. Tidak ada "tebakan" — hanya diagnosis yang memiliki cukup bukti yang ditampilkan.'],
                ['Confidence Score', 'Setiap hasil dilengkapi persentase keyakinan, sehingga Anda tahu seberapa pasti diagnosisnya.'],
                ['Safety First', 'Untuk kerusakan kritis, sistem otomatis menonaktifkan panduan mandiri dan mewajibkan teknisi profesional.'],
            ] as [$title, $desc])
            <div class="flex gap-3 bg-white rounded-xl p-5 border border-black/[.04]">
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-6 h-6 rounded-full bg-fm-primary/10 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-fm-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div>
                    <span class="font-bold text-fm-dark" style="letter-spacing:-.01em;">{{ $title }}</span>
                    <p class="body-sm mt-1.5">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <p class="text-fm-muted mb-6">Siap untuk mencoba?</p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-fm-primary text-white px-8 py-3.5 rounded-xl font-bold hover:bg-fm-primary-dark transition-all hover:-translate-y-0.5 hover:shadow-lg">
            Mulai Diagnosis Sekarang
        </a>
    </div>
</div>
@endsection
