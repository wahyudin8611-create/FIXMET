@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(145deg, #0a0f1e 0%, #0d1a40 40%, #150d38 70%, #0f0a2a 100%);
    }
    .floating-card {
        animation: float 6s ease-in-out infinite;
    }
    .floating-card-delay {
        animation: float 6s ease-in-out 2s infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }
    .gradient-text {
        background: linear-gradient(135deg, #60a5fa, #a78bfa, #f9a8d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .step-number {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .glow-blue { box-shadow: 0 0 30px rgba(37, 99, 235, 0.3); }
    .glow-violet { box-shadow: 0 0 30px rgba(124, 58, 237, 0.3); }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════ --}}
<section class="hero-bg relative overflow-hidden min-h-[85vh] flex items-center">

    {{-- Decorative blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-[700px] h-[700px] rounded-full opacity-15"
             style="background: radial-gradient(circle, #3b82f6, transparent 60%); transform: translate(30%, -30%);"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full opacity-10"
             style="background: radial-gradient(circle, #7c3aed, transparent 60%); transform: translate(-30%, 30%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full opacity-5"
             style="background: radial-gradient(circle, #2563eb, transparent 50%);"></div>
        {{-- Grid dots --}}
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 35px 35px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-14">

            {{-- Left: copy --}}
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-6"
                     style="background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.3); color: #93c5fd;">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></div>
                    AI-Powered Expert System · Forward Chaining
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-none tracking-tight mb-5">
                    Diagnosa<br>
                    <span class="gradient-text">Perangkat Anda</span><br>
                    Secara Cerdas
                </h1>

                <p class="text-slate-400 text-lg md:text-xl leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
                    Foto kerusakannya, jawab beberapa pertanyaan, dan dapatkan diagnosis AI akurat dalam hitungan menit. Perbaiki sendiri atau hubungi teknisi terverifikasi.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    @auth
                        @if(auth()->user()->isUser())
                        <a href="{{ route('diagnosis.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-7 py-4 font-bold text-white rounded-2xl text-base shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5"
                           style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                            </svg>
                            Mulai Diagnosis Sekarang
                        </a>
                        @endif
                    @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 px-7 py-4 font-bold text-white rounded-2xl text-base shadow-xl hover:shadow-2xl transition-all hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        Mulai Gratis Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('how-it-works') }}"
                       class="inline-flex items-center justify-center gap-2 px-7 py-4 font-semibold rounded-2xl text-base transition-all hover:-translate-y-0.5"
                       style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.85);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lihat Cara Kerja
                    </a>
                    @endauth
                </div>

                {{-- Social proof --}}
                <div class="mt-10 flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            @foreach(['A','B','C','D','E'] as $i => $l)
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-bold text-white"
                                 style="border-color: #0a0f1e; background: hsl({{ 200 + $i*45 }},70%,50%);">
                                {{ $l }}
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">10.000+ Pengguna</p>
                            <div class="flex items-center gap-0.5">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                                <span class="text-slate-400 text-xs ml-1">4.9/5</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-slate-700 hidden sm:block"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.15);">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Akurasi 95%+</p>
                            <p class="text-slate-500 text-xs">Berbasis expert system</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: floating cards --}}
            <div class="flex-shrink-0 hidden lg:flex items-center justify-center w-[420px] relative h-[480px]">

                {{-- Main diagnosis card --}}
                <div class="floating-card absolute left-0 top-8 w-72 rounded-2xl p-5 shadow-2xl glow-blue"
                     style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(10px);">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-xs font-semibold text-slate-300">Diagnosis Selesai</span>
                    </div>
                    <p class="text-white font-bold mb-1">Kerusakan Hard Drive</p>
                    <p class="text-slate-400 text-xs mb-3">Laptop ASUS X45U · 2 menit lalu</p>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="flex-1 h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.1);">
                            <div class="h-full rounded-full" style="width: 87%; background: linear-gradient(90deg, #3b82f6, #7c3aed);"></div>
                        </div>
                        <span class="text-xs font-bold text-blue-300">87%</span>
                    </div>
                    <p class="text-xs text-slate-500">Confidence Score</p>
                    <div class="mt-3 flex gap-1.5">
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-orange-900/40 text-orange-300">High Severity</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-blue-900/40 text-blue-300">Professional Only</span>
                    </div>
                </div>

                {{-- Technician card --}}
                <div class="floating-card-delay absolute right-0 top-28 w-60 rounded-2xl p-4 shadow-xl glow-violet"
                     style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <p class="text-xs text-slate-400 mb-2 font-medium">Teknisi Terdekat</p>
                    <div class="flex items-center gap-2.5 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">A</div>
                        <div>
                            <p class="text-white text-sm font-semibold">Ahmad T.</p>
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-slate-400 text-xs">4.9 · 120 jobs</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-emerald-400 font-semibold flex items-center gap-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                            Tersedia sekarang
                        </span>
                    </div>
                </div>

                {{-- Step guide card --}}
                <div class="absolute bottom-0 left-8 w-64 rounded-2xl p-4 shadow-xl"
                     style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <p class="text-xs text-slate-400 mb-2 font-medium">Panduan Perbaikan</p>
                    <p class="text-white text-sm font-semibold mb-2.5">Cara Ganti Hard Drive Laptop</p>
                    <div class="space-y-1.5">
                        @foreach(['Matikan laptop & cabut daya', 'Buka sekrup cover bawah', 'Lepas konektor HDD lama'] as $i => $step)
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background: {{ $i === 0 ? 'rgba(37,99,235,0.4)' : 'rgba(255,255,255,0.08)' }}; border: 1px solid {{ $i === 0 ? 'rgba(37,99,235,0.5)' : 'rgba(255,255,255,0.1)' }}">
                                <span class="text-[9px] font-bold {{ $i === 0 ? 'text-blue-300' : 'text-slate-500' }}">{{ $i+1 }}</span>
                            </div>
                            <p class="text-xs {{ $i === 0 ? 'text-slate-300' : 'text-slate-600' }}">{{ $step }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     HOW IT WORKS
════════════════════════════════════════════ --}}
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3" style="background: rgba(37,99,235,0.08); color: #2563eb;">Proses Mudah</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">Diagnosis dalam 4 Langkah</h2>
        <p class="text-gray-500 max-w-lg mx-auto">Dari foto kerusakan hingga solusi lengkap — semua dalam satu platform yang mudah digunakan.</p>
    </div>

    <div class="grid md:grid-cols-4 gap-6">
        @foreach([
            ['📷', '01', 'Upload Foto', 'Foto kerusakan perangkat dari berbagai sudut untuk analisis visual AI', 'blue'],
            ['🔍', '02', 'Jawab Gejala', 'Sistem pakar mengajukan pertanyaan Ya/Tidak yang presisi', 'violet'],
            ['📋', '03', 'Terima Diagnosis', 'Dapatkan hasil lengkap: nama kerusakan, tingkat keparahan, confidence score', 'indigo'],
            ['🔧', '04', 'Ambil Tindakan', 'Ikuti panduan mandiri atau booking teknisi profesional terverifikasi', 'purple'],
        ] as [$emoji, $num, $title, $desc, $color])
        <div class="card-hover relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm group">
            <div class="absolute top-4 right-4 text-4xl font-black opacity-5 group-hover:opacity-10 transition-opacity step-number leading-none">
                {{ $num }}
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5 text-2xl"
                 style="background: linear-gradient(135deg, {{ $color === 'blue' ? '#eff6ff, #dbeafe' : ($color === 'violet' ? '#f5f3ff, #ede9fe' : ($color === 'indigo' ? '#eef2ff, #e0e7ff' : '#faf5ff, #f3e8ff')) }});">
                {{ $emoji }}
            </div>
            <div class="text-xs font-bold text-gray-300 mb-1 uppercase tracking-widest">Langkah {{ $num }}</div>
            <h3 class="font-bold text-gray-900 mb-2 text-base">{{ $title }}</h3>
            <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>

            @if(!$loop->last)
            <div class="hidden md:block absolute top-1/2 -right-3 -translate-y-1/2 z-10">
                <div class="w-6 h-6 rounded-full flex items-center justify-center shadow-sm" style="background: #f3f4f6;">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FEATURES
════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3" style="background: rgba(124,58,237,0.08); color: #7c3aed;">Teknologi Terdepan</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">Fitur yang Membuat Kami Berbeda</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Dibangun dengan teknologi AI dan sistem pakar yang sama seperti yang digunakan oleh para ahli elektronik profesional.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                [
                    'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18',
                    'badge' => 'Expert System',
                    'title' => 'Forward Chaining AI',
                    'desc' => 'Menggunakan metode inferensi maju: dari fakta gejala menuju kesimpulan diagnosis — sama persis seperti cara dokter mendiagnosis pasien.',
                    'accent' => 'blue',
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'badge' => 'Confidence Score',
                    'title' => 'Akurasi Terukur',
                    'desc' => 'Setiap diagnosis dilengkapi persentase keyakinan berbasis bobot aturan. Anda tahu seberapa pasti hasilnya sebelum mengambil tindakan.',
                    'accent' => 'violet',
                ],
                [
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    'badge' => 'Teknisi Mitra',
                    'title' => 'Jaringan Teknisi Terverifikasi',
                    'desc' => 'Semua teknisi melalui proses verifikasi dokumen dan keahlian. Rating real dari pelanggan asli memastikan Anda mendapat yang terbaik.',
                    'accent' => 'emerald',
                ],
                [
                    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'badge' => 'Panduan DIY',
                    'title' => 'Ribuan Panduan Perbaikan',
                    'desc' => 'Panduan step-by-step dengan foto dan estimasi biaya untuk perbaikan mandiri. Hemat biaya teknisi untuk masalah yang bisa ditangani sendiri.',
                    'accent' => 'orange',
                ],
                [
                    'icon' => 'M3 9a2 2 0 014 0v0a2 2 0 01-4 0zm0 0a2 2 0 000 4h.5M21 9a2 2 0 00-4 0v0a2 2 0 004 0zm0 0a2 2 0 010 4h-.5M12 11v2m0 0v2m0-2h2m-2 0H10',
                    'badge' => 'Safety First',
                    'title' => 'Perlindungan Otomatis',
                    'desc' => 'Untuk kerusakan kritis, sistem otomatis menonaktifkan panduan mandiri dan mewajibkan teknisi profesional demi keamanan Anda.',
                    'accent' => 'red',
                ],
                [
                    'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'badge' => 'Chat Real-Time',
                    'title' => 'Komunikasi Langsung',
                    'desc' => 'Chat langsung dengan teknisi pilihan Anda sebelum dan sesudah booking. Diskusikan masalah, estimasi waktu, dan biaya tanpa perantara.',
                    'accent' => 'teal',
                ],
            ] as $feature)
            @php
                $accentMap = [
                    'blue' => ['bg' => '#eff6ff', 'icon_bg' => 'linear-gradient(135deg, #2563eb, #3b82f6)', 'badge' => 'rgba(37,99,235,0.08)', 'badge_text' => '#2563eb'],
                    'violet' => ['bg' => '#f5f3ff', 'icon_bg' => 'linear-gradient(135deg, #7c3aed, #8b5cf6)', 'badge' => 'rgba(124,58,237,0.08)', 'badge_text' => '#7c3aed'],
                    'emerald' => ['bg' => '#ecfdf5', 'icon_bg' => 'linear-gradient(135deg, #059669, #10b981)', 'badge' => 'rgba(5,150,105,0.08)', 'badge_text' => '#059669'],
                    'orange' => ['bg' => '#fff7ed', 'icon_bg' => 'linear-gradient(135deg, #ea580c, #f97316)', 'badge' => 'rgba(234,88,12,0.08)', 'badge_text' => '#ea580c'],
                    'red' => ['bg' => '#fef2f2', 'icon_bg' => 'linear-gradient(135deg, #dc2626, #ef4444)', 'badge' => 'rgba(220,38,38,0.08)', 'badge_text' => '#dc2626'],
                    'teal' => ['bg' => '#f0fdfa', 'icon_bg' => 'linear-gradient(135deg, #0d9488, #14b8a6)', 'badge' => 'rgba(13,148,136,0.08)', 'badge_text' => '#0d9488'],
                ];
                $a = $accentMap[$feature['accent']];
            @endphp
            <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                         style="background: {{ $a['icon_bg'] }};">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full mt-0.5"
                          style="background: {{ $a['badge'] }}; color: {{ $a['badge_text'] }};">
                        {{ $feature['badge'] }}
                    </span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2 text-base">{{ $feature['title'] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CTA SECTION
════════════════════════════════════════════ --}}
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden p-12 text-center"
             style="background: linear-gradient(135deg, #0a0f1e 0%, #0d1a40 50%, #150d38 100%);">

            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-15"
                 style="background: radial-gradient(circle, #3b82f6, transparent 60%); transform: translate(30%, -30%);"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full opacity-10"
                 style="background: radial-gradient(circle, #7c3aed, transparent 60%); transform: translate(-30%, 30%);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-5"
                     style="background: rgba(37,99,235,0.2); border: 1px solid rgba(37,99,235,0.3); color: #93c5fd;">
                    ✦ Gratis selamanya untuk pengguna
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
                    Siap mendiagnosa<br>perangkat Anda?
                </h2>
                <p class="text-slate-400 text-lg mb-8 max-w-md mx-auto">
                    Bergabung dengan ribuan pengguna yang sudah mempercayakan diagnosis elektronik mereka ke FIXMATE.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-2xl text-base hover:-translate-y-0.5 transition-all shadow-xl hover:shadow-2xl"
                       style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        Daftar & Mulai Gratis
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('diagnosis.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-2xl text-base hover:-translate-y-0.5 transition-all shadow-xl hover:shadow-2xl"
                       style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        Mulai Diagnosis Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @endauth
                    <a href="{{ route('how-it-works') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 font-semibold rounded-2xl text-base transition-all hover:-translate-y-0.5"
                       style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                {{-- Trust badges --}}
                <div class="mt-10 flex flex-wrap items-center justify-center gap-6">
                    @foreach(['✓ Gratis untuk pengguna', '✓ Data terenkripsi', '✓ 100+ teknisi aktif', '✓ Akurasi 95%+'] as $badge)
                    <span class="text-sm text-slate-500 font-medium">{{ $badge }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
