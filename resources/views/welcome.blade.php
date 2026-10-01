@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(145deg, #0f1f1b 0%, #162e27 40%, #1A2332 70%, #121c28 100%);
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
        background: linear-gradient(135deg, #5BA897, #E2B85B, #D4A63E);
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
        background: linear-gradient(135deg, #3D8B7A, #2A6356);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .glow-teal { box-shadow: 0 0 30px rgba(61, 139, 122, 0.3); }
    .glow-amber { box-shadow: 0 0 30px rgba(226, 184, 91, 0.3); }
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="hero-bg relative overflow-hidden min-h-[85vh] flex items-center">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-[700px] h-[700px] rounded-full opacity-15"
             style="background: radial-gradient(circle, #3D8B7A, transparent 60%); transform: translate(30%, -30%);"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full opacity-10"
             style="background: radial-gradient(circle, #E2B85B, transparent 60%); transform: translate(-30%, 30%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full opacity-5"
             style="background: radial-gradient(circle, #3D8B7A, transparent 50%);"></div>
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 35px 35px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-14">

            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full mb-7"
                     style="background: rgba(61,139,122,0.15); border: 1px solid rgba(61,139,122,0.3); color: #5BA897; font-size:.6875rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase;">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                    Sistem Pakar &middot; Forward Chaining
                </div>

                <h1 class="text-white mb-6" style="font-size:clamp(3rem,6vw,4.5rem);font-weight:800;letter-spacing:-.035em;line-height:1.04;">
                    Diagnosa<br>
                    <span class="gradient-text">Perangkat Anda</span><br>
                    Secara Cerdas
                </h1>

                <p class="max-w-xl mx-auto lg:mx-0 mb-9" style="font-size:clamp(1rem,2vw,1.25rem);line-height:1.75;color:#94a3b8;">
                    Foto kerusakannya, jawab beberapa pertanyaan, dan dapatkan diagnosis akurat dalam hitungan menit. Perbaiki sendiri atau hubungi teknisi terverifikasi.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    @auth
                        @if(auth()->user()->isUser())
                        <a href="{{ route('user.diagnosis.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-7 py-4 font-bold text-white rounded-2xl text-base shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 bg-fm-primary hover:bg-fm-primary-dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                            </svg>
                            Mulai Diagnosis Sekarang
                        </a>
                        @endif
                    @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 px-7 py-4 font-bold text-white rounded-2xl text-base shadow-xl hover:shadow-2xl transition-all hover:-translate-y-0.5 bg-fm-primary hover:bg-fm-primary-dark">
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

                <div class="mt-10 flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            @foreach(['A','B','C','D','E'] as $i => $l)
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-bold text-white"
                                 style="border-color: #0f1f1b; background: hsl({{ 150 + $i*30 }},50%,45%);">
                                {{ $l }}
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <p class="text-white font-semibold" style="font-size:.875rem;letter-spacing:-.01em;">10.000+ Pengguna</p>
                            <div class="flex items-center gap-0.5">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-3 h-3 text-fm-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                                <span class="text-slate-400 ml-1" style="font-size:.75rem;font-variant-numeric:tabular-nums;">4.9/5</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-slate-700 hidden sm:block"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(61,139,122,0.15);">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold" style="font-size:.875rem;letter-spacing:-.01em;">Akurasi 95%+</p>
                            <p class="text-slate-500" style="font-size:.75rem;">Berbasis expert system</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 hidden lg:flex items-center justify-center w-[420px] relative h-[480px]">

                <div class="floating-card absolute left-0 top-8 w-72 rounded-2xl p-5 shadow-2xl glow-teal"
                     style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(10px);">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-xs font-semibold text-slate-300">Diagnosis Selesai</span>
                    </div>
                    <p class="text-white font-bold mb-1">Kerusakan Hard Drive</p>
                    <p class="text-slate-400 text-xs mb-3">Laptop ASUS X45U &middot; 2 menit lalu</p>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="flex-1 h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.1);">
                            <div class="h-full rounded-full" style="width: 87%; background: linear-gradient(90deg, #3D8B7A, #5BA897);"></div>
                        </div>
                        <span class="text-xs font-bold text-emerald-300">87%</span>
                    </div>
                    <p class="text-xs text-slate-500">Confidence Score</p>
                    <div class="mt-3 flex gap-1.5">
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-orange-900/40 text-orange-300">High Severity</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold" style="background: rgba(61,139,122,0.2); color: #5BA897;">Professional Only</span>
                    </div>
                </div>

                <div class="floating-card-delay absolute right-0 top-28 w-60 rounded-2xl p-4 shadow-xl glow-amber"
                     style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <p class="text-xs text-slate-400 mb-2 font-medium">Teknisi Terdekat</p>
                    <div class="flex items-center gap-2.5 mb-2">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #3D8B7A, #5BA897);">A</div>
                        <div>
                            <p class="text-white text-sm font-semibold">Ahmad T.</p>
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-fm-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-slate-400 text-xs">4.9 &middot; 120 jobs</span>
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

                <div class="absolute bottom-0 left-8 w-64 rounded-2xl p-4 shadow-xl"
                     style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <p class="text-xs text-slate-400 mb-2 font-medium">Panduan Perbaikan</p>
                    <p class="text-white text-sm font-semibold mb-2.5">Cara Ganti Hard Drive Laptop</p>
                    <div class="space-y-1.5">
                        @foreach(['Matikan laptop & cabut daya', 'Buka sekrup cover bawah', 'Lepas konektor HDD lama'] as $i => $step)
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background: {{ $i === 0 ? 'rgba(61,139,122,0.4)' : 'rgba(255,255,255,0.08)' }}; border: 1px solid {{ $i === 0 ? 'rgba(61,139,122,0.5)' : 'rgba(255,255,255,0.1)' }}">
                                <span class="text-[9px] font-bold {{ $i === 0 ? 'text-emerald-300' : 'text-slate-500' }}">{{ $i+1 }}</span>
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

{{-- HOW IT WORKS --}}
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
        <span class="inline-block px-3.5 py-1.5 rounded-full mb-4" style="background:rgba(61,139,122,0.08);color:#3D8B7A;font-size:.6875rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">Proses Mudah</span>
        <h2 style="font-size:clamp(1.75rem,4vw,2.5rem);font-weight:800;letter-spacing:-.03em;line-height:1.1;color:#1F2937;text-wrap:balance;" class="mb-4">Diagnosis dalam 4 Langkah</h2>
        <p class="max-w-lg mx-auto" style="font-size:1.0625rem;line-height:1.75;color:#6B7280;">Dari foto kerusakan hingga solusi lengkap &mdash; semua dalam satu platform yang mudah digunakan.</p>
    </div>

    <div class="grid md:grid-cols-4 gap-6">
        @foreach([
            ['📷', '01', 'Upload Foto', 'Foto kerusakan perangkat dari berbagai sudut untuk analisis visual'],
            ['🔍', '02', 'Jawab Gejala', 'Sistem pakar mengajukan pertanyaan Ya/Tidak yang presisi'],
            ['📋', '03', 'Terima Diagnosis', 'Dapatkan hasil lengkap: nama kerusakan, tingkat keparahan, confidence score'],
            ['🔧', '04', 'Ambil Tindakan', 'Ikuti panduan mandiri atau booking teknisi profesional terverifikasi'],
        ] as [$emoji, $num, $title, $desc])
        <div class="card-hover relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm group">
            <div class="absolute top-4 right-4 text-4xl font-black opacity-5 group-hover:opacity-10 transition-opacity step-number leading-none">
                {{ $num }}
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5 text-2xl bg-fm-primary/5">
                {{ $emoji }}
            </div>
            <div class="mb-1.5" style="font-size:.6875rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#D1D5DB;">Langkah {{ $num }}</div>
            <h3 class="font-bold text-gray-900 mb-2" style="font-size:.9375rem;letter-spacing:-.02em;">{{ $title }}</h3>
            <p style="font-size:.875rem;line-height:1.7;color:#6B7280;">{{ $desc }}</p>

            @if(!$loop->last)
            <div class="hidden md:block absolute top-1/2 -right-3 -translate-y-1/2 z-10">
                <div class="w-6 h-6 rounded-full flex items-center justify-center shadow-sm bg-gray-100">
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

{{-- FEATURES --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-3.5 py-1.5 rounded-full mb-4" style="background:rgba(61,139,122,0.08);color:#3D8B7A;font-size:.6875rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">Teknologi Terdepan</span>
            <h2 style="font-size:clamp(1.75rem,4vw,2.5rem);font-weight:800;letter-spacing:-.03em;line-height:1.1;color:#1F2937;text-wrap:balance;" class="mb-4">Fitur yang Membuat Kami Berbeda</h2>
            <p class="max-w-lg mx-auto" style="font-size:1.0625rem;line-height:1.75;color:#6B7280;">Dibangun dengan teknologi sistem pakar yang sama seperti yang digunakan oleh para ahli elektronik profesional.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                [
                    'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18',
                    'badge' => 'Expert System',
                    'title' => 'Forward Chaining',
                    'desc' => 'Menggunakan metode inferensi maju: dari fakta gejala menuju kesimpulan diagnosis — sama seperti cara dokter mendiagnosis pasien.',
                    'color' => '#3D8B7A',
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'badge' => 'Confidence Score',
                    'title' => 'Akurasi Terukur',
                    'desc' => 'Setiap diagnosis dilengkapi persentase keyakinan berbasis bobot aturan. Anda tahu seberapa pasti hasilnya sebelum mengambil tindakan.',
                    'color' => '#2A6356',
                ],
                [
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    'badge' => 'Teknisi Mitra',
                    'title' => 'Jaringan Teknisi Terverifikasi',
                    'desc' => 'Semua teknisi melalui proses verifikasi dokumen dan keahlian. Rating real dari pelanggan asli memastikan Anda mendapat yang terbaik.',
                    'color' => '#E2B85B',
                ],
                [
                    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'badge' => 'Panduan DIY',
                    'title' => 'Ribuan Panduan Perbaikan',
                    'desc' => 'Panduan step-by-step dengan foto dan estimasi biaya untuk perbaikan mandiri. Hemat biaya teknisi untuk masalah yang bisa ditangani sendiri.',
                    'color' => '#5BA897',
                ],
                [
                    'icon' => 'M3 9a2 2 0 014 0v0a2 2 0 01-4 0zm0 0a2 2 0 000 4h.5M21 9a2 2 0 00-4 0v0a2 2 0 004 0zm0 0a2 2 0 010 4h-.5M12 11v2m0 0v2m0-2h2m-2 0H10',
                    'badge' => 'Safety First',
                    'title' => 'Perlindungan Otomatis',
                    'desc' => 'Untuk kerusakan kritis, sistem otomatis menonaktifkan panduan mandiri dan mewajibkan teknisi profesional demi keamanan Anda.',
                    'color' => '#D4A63E',
                ],
                [
                    'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                    'badge' => 'Chat Real-Time',
                    'title' => 'Komunikasi Langsung',
                    'desc' => 'Chat langsung dengan teknisi pilihan Anda sebelum dan sesudah booking. Diskusikan masalah, estimasi waktu, dan biaya tanpa perantara.',
                    'color' => '#3D8B7A',
                ],
            ] as $feature)
            <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm text-white"
                         style="background: {{ $feature['color'] }};">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full mt-0.5"
                          style="background: {{ $feature['color'] }}10; color: {{ $feature['color'] }};">
                        {{ $feature['badge'] }}
                    </span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2" style="font-size:.9375rem;letter-spacing:-.02em;">{{ $feature['title'] }}</h3>
                <p style="font-size:.875rem;line-height:1.7;color:#6B7280;">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden p-12 text-center"
             style="background: linear-gradient(135deg, #0f1f1b 0%, #162e27 50%, #1A2332 100%);">

            <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-15"
                 style="background: radial-gradient(circle, #3D8B7A, transparent 60%); transform: translate(30%, -30%);"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full opacity-10"
                 style="background: radial-gradient(circle, #E2B85B, transparent 60%); transform: translate(-30%, 30%);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6"
                     style="background:rgba(61,139,122,0.2);border:1px solid rgba(61,139,122,0.3);color:#5BA897;font-size:.6875rem;font-weight:700;letter-spacing:.14em;">
                    ✦ Gratis selamanya untuk pengguna
                </div>
                <h2 class="text-white mb-5" style="font-size:clamp(1.75rem,4vw,2.5rem);font-weight:800;letter-spacing:-.03em;line-height:1.1;text-wrap:balance;">
                    Siap mendiagnosa<br>perangkat Anda?
                </h2>
                <p class="max-w-md mx-auto mb-9" style="font-size:1.125rem;line-height:1.75;color:#94a3b8;">
                    Bergabung dengan ribuan pengguna yang sudah mempercayakan diagnosis elektronik mereka ke FIXMET.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-2xl text-base hover:-translate-y-0.5 transition-all shadow-xl hover:shadow-2xl bg-fm-primary hover:bg-fm-primary-dark">
                        Daftar & Mulai Gratis
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('user.diagnosis.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-2xl text-base hover:-translate-y-0.5 transition-all shadow-xl hover:shadow-2xl bg-fm-primary hover:bg-fm-primary-dark">
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

                <div class="mt-10 flex flex-wrap items-center justify-center gap-6">
                    @foreach(['✓ Gratis untuk pengguna', '✓ Data terenkripsi', '✓ 100+ teknisi aktif', '✓ Akurasi 95%+'] as $badge)
                    <span class="text-slate-500 font-medium" style="font-size:.8125rem;">{{ $badge }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
