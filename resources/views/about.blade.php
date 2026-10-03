@extends('layouts.app')
@section('title', 'Tentang FIXMATE')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-16">

    {{-- Hero --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-fm-primary/5 border border-fm-primary/10 mb-7">
            <span class="w-1.5 h-1.5 rounded-full bg-fm-primary animate-pulse"></span>
            <span class="eyebrow text-fm-primary">Tentang Kami</span>
        </div>
        <h1 class="display-xl text-fm-dark mb-5" style="font-size:clamp(2.25rem,5vw,3rem);">Tentang FIXMATE</h1>
        <p class="body-lg max-w-xl mx-auto">
            Platform diagnosis kerusakan perangkat berbasis foto dan sistem pakar yang menghubungkan pengguna dengan teknisi profesional terverifikasi.
        </p>
    </div>

    {{-- Misi & Teknologi --}}
    <div class="grid md:grid-cols-2 gap-6 mb-16">
        <div class="bg-white rounded-2xl p-8 border border-black/[.04] shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-fm-primary/10 flex items-center justify-center mb-5">
                <svg class="w-6 h-6 text-fm-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="font-bold text-fm-dark mb-3" style="font-size:1.25rem;letter-spacing:-.02em;">Misi Kami</h2>
            <p class="body-md">
                FIXMATE hadir untuk menghubungkan pengguna dengan solusi perbaikan elektronik yang tepat, cepat, dan terpercaya.
                Kami memanfaatkan sistem pakar untuk membantu mengidentifikasi kerusakan perangkat elektronik
                dan menghubungkan pengguna dengan teknisi profesional terverifikasi.
            </p>
        </div>
        <div class="bg-white rounded-2xl p-8 border border-black/[.04] shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-fm-accent/10 flex items-center justify-center mb-5">
                <svg class="w-6 h-6 text-fm-accent-hover" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="font-bold text-fm-dark mb-3" style="font-size:1.25rem;letter-spacing:-.02em;">Teknologi Kami</h2>
            <p class="body-md">
                Sistem Expert System kami menggunakan metode Forward Chaining dengan algoritma pencocokan aturan AND logic.
                Setiap diagnosis menghasilkan nilai confidence yang mencerminkan tingkat keyakinan sistem terhadap kerusakan yang teridentifikasi.
            </p>
        </div>
    </div>

    {{-- Nilai-Nilai --}}
    <div class="bg-fm-primary/[.04] rounded-3xl p-8 sm:p-12 mb-16 border border-fm-primary/[.08]">
        <h2 class="display-md text-fm-dark text-center mb-10" style="font-size:1.5rem;">Nilai-Nilai FIXMATE</h2>
        <div class="grid sm:grid-cols-3 gap-8">
            @foreach([
                ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Akurasi', 'Diagnosis berbasis data dan aturan pakar yang telah tervalidasi', '#3D8B7A'],
                ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Kepercayaan', 'Semua teknisi melalui proses verifikasi dan seleksi yang ketat', '#2A6356'],
                ['M13 10V3L4 14h7v7l9-11h-7z', 'Kecepatan', 'Solusi dan koneksi teknisi dalam hitungan menit', '#E2B85B'],
            ] as [$icon, $title, $desc, $color])
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center" style="background: {{ $color }}15;">
                    <svg class="w-7 h-7" style="color: {{ $color }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-fm-dark mb-2" style="font-size:1.0625rem;letter-spacing:-.02em;">{{ $title }}</h3>
                <p class="body-sm">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Cara Kerja Singkat --}}
    <div class="bg-fm-dark rounded-3xl p-8 sm:p-12 mb-16">
        <h2 class="display-md text-white text-center mb-10" style="font-size:1.5rem;">Bagaimana FIXMATE Bekerja</h2>
        <div class="grid sm:grid-cols-4 gap-6">
            @foreach([
                ['01', 'Upload Foto', 'Ambil foto perangkat yang bermasalah dari berbagai sudut.'],
                ['02', 'Jawab Pertanyaan', 'Sistem pakar bertanya lebih lanjut untuk mempersempit diagnosis.'],
                ['03', 'Lihat Diagnosis', 'Dapatkan hasil diagnosis dengan confidence score dan alasan logis.'],
                ['04', 'Perbaiki / Booking', 'Ikuti panduan mandiri atau booking teknisi terverifikasi.'],
            ] as [$num, $title, $desc])
            <div class="text-center">
                <div class="w-10 h-10 rounded-full bg-fm-primary mx-auto mb-3 flex items-center justify-center">
                    <span class="text-white font-extrabold text-sm">{{ $num }}</span>
                </div>
                <h3 class="font-bold text-white mb-1.5" style="font-size:.875rem;letter-spacing:-.01em;">{{ $title }}</h3>
                <p style="font-size:.8125rem;line-height:1.65;color:rgba(255,255,255,.45);">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <p class="text-fm-muted mb-6">Siap untuk mencoba?</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-fm-primary text-white px-8 py-3.5 rounded-xl font-bold hover:bg-fm-primary-dark transition-all hover:-translate-y-0.5 hover:shadow-lg">
                Mulai Gunakan FIXMATE
            </a>
            <a href="{{ route('how-it-works') }}" class="inline-flex items-center gap-2 border-2 border-fm-primary text-fm-primary px-8 py-3.5 rounded-xl font-bold hover:bg-fm-primary/5 transition-colors">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>

</div>
@endsection
