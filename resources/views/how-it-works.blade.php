@extends('layouts.app')
@section('title', 'Cara Kerja FIXMATE')

@push('styles')
<style>
    .hiw-circuit {
        background-color: #F5F6F3;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160' viewBox='0 0 160 160'%3E%3Cg fill='none' stroke='%233D8B7A' stroke-opacity='.07' stroke-width='1.5'%3E%3Cpath d='M0 40h40l20 20h40M100 60v40l20 20h40M20 160v-40l20-20h30M120 0v20l-20 20'/%3E%3C/g%3E%3Cg fill='%233D8B7A' fill-opacity='.09'%3E%3Ccircle cx='100' cy='60' r='3'/%3E%3Ccircle cx='70' cy='100' r='3'/%3E%3Ccircle cx='100' cy='40' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }
    .hiw-card { transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .hiw-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px -12px rgba(42,99,86,.22); border-color: rgba(61,139,122,.45); }
</style>
@endpush

@section('content')
<div class="hiw-circuit">
<div class="max-w-[88rem] mx-auto px-4 sm:px-6 py-16">

    {{-- Header --}}
    <div class="text-center mb-14">
        <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-fm-primary/5 border border-fm-primary/10 mb-7">
            <span class="w-1.5 h-1.5 rounded-full bg-fm-primary animate-pulse"></span>
            <span class="eyebrow text-fm-primary">Cara Kerja</span>
        </div>
        <h1 class="display-xl text-fm-dark mb-5" style="font-size:clamp(2.25rem,5vw,3rem);">Cara Kerja FIXMATE</h1>
        <p class="body-lg max-w-xl mx-auto">Lima langkah dari foto kerusakan hingga teknisi tiba di depan pintu Anda</p>
    </div>

    {{-- Steps flowchart --}}
    <ol class="grid gap-4 xl:gap-2.5 max-w-md xl:max-w-none mx-auto xl:grid-cols-[1fr_auto_1fr_auto_1fr_auto_1fr_auto_1fr] items-stretch mb-20">

        {{-- Step 1 --}}
        <li class="hiw-card bg-white rounded-2xl border-2 border-fm-primary/20 shadow-sm p-5 flex flex-col">
            <div class="h-48 flex items-center justify-center mb-6">
                <svg viewBox="0 0 240 190" class="w-full h-full" aria-hidden="true">
                    <circle cx="125" cy="105" r="72" fill="#EEF7F5"/>
                    {{-- big cracked phone --}}
                    <rect x="118" y="22" width="78" height="140" rx="12" fill="#1A2332"/>
                    <rect x="124" y="30" width="66" height="124" rx="7" fill="#D5EDE8"/>
                    <rect x="148" y="25" width="18" height="3" rx="1.5" fill="#2A6356"/>
                    <g stroke="#1A2332" stroke-width="1.4" fill="none" stroke-linecap="round">
                        <path d="M158 88l-14-22-6-20M158 88l18-24 6-18M158 88l-22 8-12 14M158 88l26 6M158 88l4 28 -8 22M158 88l-6 12-20 20"/>
                        <path d="M146 70l8-4M170 70l6 6M150 100l-8-8M172 98l-6 10"/>
                    </g>
                    {{-- photo card --}}
                    <g transform="rotate(-8 205 150)">
                        <rect x="180" y="128" width="50" height="42" rx="4" fill="#fff" stroke="#1A2332" stroke-width="2"/>
                        <rect x="185" y="133" width="40" height="28" rx="2" fill="#D5EDE8"/>
                        <path d="M185 161l12-14 9 9 6-6 13 11z" fill="#3D8B7A"/>
                        <circle cx="216" cy="140" r="3.5" fill="#F08A5D"/>
                    </g>
                    {{-- person --}}
                    <path d="M40 190c0-34 14-54 40-54s40 20 40 54z" fill="#3D8B7A"/>
                    <circle cx="78" cy="102" r="20" fill="#F4C9A8"/>
                    <path d="M58 98c0-16 10-24 22-24 13 0 21 8 19 20-6-6-14-7-22-6-7 1-13 4-19 10z" fill="#1A2332"/>
                    <path d="M84 112c3 3 8 3 10 0" stroke="#1A2332" stroke-width="1.6" fill="none" stroke-linecap="round"/>
                    {{-- hand phone --}}
                    <rect x="98" y="104" width="24" height="42" rx="5" fill="#2A6356" stroke="#1A2332" stroke-width="2"/>
                    <circle cx="110" cy="122" r="6" fill="#1A2332"/>
                    <circle cx="110" cy="122" r="2.5" fill="#7EC4B7"/>
                    <path d="M96 140c-6 4-14 8-22 6" stroke="#F4C9A8" stroke-width="9" stroke-linecap="round" fill="none"/>
                    {{-- pulse badge --}}
                    <rect x="18" y="34" width="38" height="32" rx="7" fill="#F08A5D"/>
                    <path d="M24 50h7l3-7 5 14 3-7h8" stroke="#fff" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M60 50h10v28" stroke="#1A2332" stroke-width="1.5" stroke-dasharray="3 3" fill="none"/>
                </svg>
            </div>
            <h3 class="font-extrabold text-fm-dark text-center mb-2" style="font-size:1.125rem;letter-spacing:-.02em;line-height:1.3;">1. Unggah Foto &amp; Pilih Perangkat</h3>
            <p class="body-md text-center">Ambil foto kerusakan, sistem identifikasi jenisnya.</p>
        </li>

        <li aria-hidden="true" class="flex items-center justify-center text-fm-primary-dark">
            <svg class="w-8 h-8 rotate-90 xl:rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m-6-6l6 6-6 6"/></svg>
        </li>

        {{-- Step 2 --}}
        <li class="hiw-card bg-white rounded-2xl border-2 border-fm-primary/20 shadow-sm p-5 flex flex-col">
            <div class="h-48 flex items-center justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 -m-6 rounded-full bg-primary-50"></div>
                    <div class="relative w-44 h-48 rounded-2xl bg-fm-dark p-2.5 pb-6 shadow-lg">
                        <div class="h-full rounded-lg bg-primary-100 flex items-center justify-center p-2">
                            <div class="bg-white rounded-xl shadow-md px-3 py-3 w-full text-center">
                                <div class="relative inline-block mb-1">
                                    <svg class="w-10 h-10" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                        <path d="M17 8a7 7 0 00-7 7 7 7 0 00-4 12 7 7 0 004 11 7 7 0 0012 2V10a6 6 0 00-5-2zM31 8a7 7 0 017 7 7 7 0 014 12 7 7 0 01-4 11 7 7 0 01-12 2V10a6 6 0 015-2z" fill="#7EC4B7" stroke="#2A6356" stroke-width="2" stroke-linejoin="round"/>
                                        <path d="M13 20c3 0 5 2 5 5M35 20c-3 0-5 2-5 5M12 31c3-1 6 0 7 3M36 31c-3-1-6 0-7 3" stroke="#2A6356" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                    <span class="absolute -top-2 -right-3 font-extrabold text-fm-primary text-lg leading-none">?</span>
                                </div>
                                <p class="font-bold text-fm-dark text-xs mb-2.5">Gejala X Terjadi?</p>
                                <div class="flex gap-1.5 justify-center">
                                    <span class="px-3 py-1 rounded-md bg-fm-primary text-white text-[11px] font-semibold">Ya</span>
                                    <span class="px-3 py-1 rounded-md text-white text-[11px] font-semibold" style="background:#F08A5D;">Tidak</span>
                                </div>
                            </div>
                        </div>
                        <span class="absolute bottom-2 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-fm-primary"></span>
                    </div>
                </div>
            </div>
            <h3 class="font-extrabold text-fm-dark text-center mb-2" style="font-size:1.125rem;letter-spacing:-.02em;line-height:1.3;">2. Jawab Diagnosa Interaktif</h3>
            <p class="body-md text-center">Sistem pakar bertanya untuk diagnosis tepat.</p>
        </li>

        <li aria-hidden="true" class="flex items-center justify-center text-fm-primary-dark">
            <svg class="w-8 h-8 rotate-90 xl:rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m-6-6l6 6-6 6"/></svg>
        </li>

        {{-- Step 3 --}}
        <li class="hiw-card bg-white rounded-2xl border-2 border-fm-primary/20 shadow-sm p-5 flex flex-col">
            <div class="h-48 flex items-center justify-center mb-6">
                <div class="w-full max-w-[13.5rem] rounded-xl border-2 border-fm-dark bg-white shadow-lg overflow-hidden">
                    <div class="flex gap-1 px-2.5 py-1.5 bg-fm-primary">
                        <span class="w-1.5 h-1.5 rounded-full" style="background:#F08A5D;"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-fm-accent"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-200"></span>
                    </div>
                    <div class="p-2.5">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                            <div class="relative w-16 h-10">
                                <svg viewBox="0 0 80 46" class="w-full h-full" aria-hidden="true">
                                    <path d="M8 42a32 32 0 0164 0" stroke="#E5E7EB" stroke-width="8" fill="none" stroke-linecap="round"/>
                                    <path d="M8 42a32 32 0 0164 0" stroke="url(#hiwGauge)" stroke-width="8" fill="none" stroke-linecap="round" pathLength="100" stroke-dasharray="85 100"/>
                                    <defs><linearGradient id="hiwGauge" x1="0" x2="1"><stop offset="0" stop-color="#F08A5D"/><stop offset=".5" stop-color="#E2B85B"/><stop offset="1" stop-color="#3D8B7A"/></linearGradient></defs>
                                </svg>
                                <span class="absolute inset-x-0 bottom-0 text-center font-extrabold text-fm-dark text-xs">85%</span>
                            </div>
                            <div class="flex-1 border-l border-gray-100 pl-2 text-center">
                                <p class="text-[10px] font-bold text-fm-dark">Severity</p>
                                <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3v18" stroke="#1A2332" stroke-width="2" stroke-linecap="round"/><path d="M7 4h11l-3 4 3 4H7z" fill="#E2B85B" stroke="#1A2332" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                        <dl class="text-[10px] leading-relaxed text-fm-dark py-1.5 border-b border-gray-100">
                            <div><dt class="inline font-bold">Diagnosa:</dt> <dd class="inline">Masalah Layar</dd></div>
                            <div><dt class="inline font-bold">Tingkat Kepercayaan:</dt> <dd class="inline">Tinggi</dd></div>
                            <div><dt class="inline font-bold">Solusi:</dt> <dd class="inline">Ganti Komponen</dd></div>
                        </dl>
                        <div class="space-y-1 pt-1.5">
                            @foreach([0, 1, 2] as $line)
                            <div class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-primary-300"></span><span class="h-1 flex-1 rounded bg-primary-100"></span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="font-extrabold text-fm-dark text-center mb-2" style="font-size:1.125rem;letter-spacing:-.02em;line-height:1.3;">3. Terima Laporan Diagnosis &amp; Solusi</h3>
            <p class="body-md text-center">Laporan lengkap dengan langkah penyelesaian.</p>
        </li>

        <li aria-hidden="true" class="flex items-center justify-center text-fm-primary-dark">
            <svg class="w-8 h-8 rotate-90 xl:rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m-6-6l6 6-6 6"/></svg>
        </li>

        {{-- Step 4 --}}
        <li class="hiw-card bg-white rounded-2xl border-2 border-fm-primary/20 shadow-sm p-5 flex flex-col">
            <div class="h-48 flex items-center justify-center mb-6">
                <svg viewBox="0 0 240 190" class="w-full h-full" aria-hidden="true">
                    {{-- toolbox --}}
                    <g transform="translate(14 8)">
                        <path d="M14 12l14 18M42 12L28 30" stroke="#6B7280" stroke-width="5" stroke-linecap="round"/>
                        <circle cx="12" cy="10" r="6" fill="none" stroke="#6B7280" stroke-width="4"/>
                        <circle cx="44" cy="10" r="6" fill="none" stroke="#6B7280" stroke-width="4"/>
                        <rect x="2" y="28" width="54" height="12" rx="3" fill="#D4A63E" stroke="#1A2332" stroke-width="2"/>
                        <rect x="8" y="40" width="16" height="16" rx="3" fill="#F08A5D" stroke="#1A2332" stroke-width="2"/>
                        <rect x="34" y="40" width="16" height="16" rx="3" fill="#F08A5D" stroke="#1A2332" stroke-width="2"/>
                    </g>
                    {{-- branching arrow --}}
                    <path d="M42 66v62M42 96h34a14 14 0 0014-14V60" stroke="#3D8B7A" stroke-width="7" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M42 128a18 18 0 0018 18h36" stroke="#3D8B7A" stroke-width="7" fill="none" stroke-linecap="round"/>
                    <path d="M98 136l12 10-12 10z" fill="#2A6356"/>
                    <path d="M80 60l10-12 10 12z" fill="#2A6356"/>
                    {{-- guide book --}}
                    <circle cx="170" cy="42" r="28" fill="#EEF7F5"/>
                    <path d="M146 26c8-3 16-3 24 3v32c-8-6-16-6-24-3zM194 26c-8-3-16-3-24 3v32c8-6 16-6 24-3z" fill="#fff" stroke="#1A2332" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M177 36l9 9M186 36l-9 9" stroke="#3D8B7A" stroke-width="2.5" stroke-linecap="round"/>
                    <text x="170" y="86" text-anchor="middle" font-size="12" font-weight="800" fill="#1A2332">Perbaikan Mandiri</text>
                    {{-- technician --}}
                    <circle cx="162" cy="132" r="26" fill="#EEF7F5"/>
                    <path d="M140 162c0-14 10-20 22-20s22 6 22 20z" fill="#2A6356"/>
                    <circle cx="162" cy="128" r="11" fill="#F4C9A8"/>
                    <path d="M150 125a12 12 0 0124 0z" fill="#3D8B7A"/>
                    <rect x="148" y="123" width="28" height="4" rx="2" fill="#2A6356"/>
                    <circle cx="186" cy="114" r="8" fill="#3D8B7A"/>
                    <path d="M182 114l3 3 5-6" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="166" y="178" text-anchor="middle" font-size="11" font-weight="800" fill="#1A2332">Panggil Teknisi Profesional</text>
                </svg>
            </div>
            <h3 class="font-extrabold text-fm-dark text-center mb-2" style="font-size:1.125rem;letter-spacing:-.02em;line-height:1.3;">4. Pilih Tindakan Selanjutnya</h3>
            <p class="body-md text-center">Ikuti panduan atau hubungi ahli <a href="{{ route('technicians.index') }}" class="text-fm-primary font-semibold hover:underline">terverifikasi</a>.</p>
        </li>

        <li aria-hidden="true" class="flex items-center justify-center text-fm-primary-dark">
            <svg class="w-8 h-8 rotate-90 xl:rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h15m-6-6l6 6-6 6"/></svg>
        </li>

        {{-- Step 5 --}}
        <li class="hiw-card bg-white rounded-2xl border-2 border-fm-primary/20 shadow-sm p-5 flex flex-col">
            <div class="h-48 flex items-center justify-center mb-6">
                <div class="relative w-full max-w-[13.5rem]">
                    <div class="rounded-xl border-2 border-fm-dark bg-white shadow-lg overflow-hidden">
                        <div class="flex items-center justify-between px-2.5 py-1.5 bg-fm-primary text-white">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                            <span class="text-[10px] font-bold">Pilih Jadwal</span>
                            <span class="w-3.5"></span>
                        </div>
                        <div class="p-2.5">
                            <div class="grid grid-cols-7 gap-0.5 text-center text-[9px] text-fm-muted mb-2">
                                @foreach(['S', 'S', 'R', 'K', 'J', 'S', 'M'] as $dayInitial)
                                <span class="font-bold text-fm-dark">{{ $dayInitial }}</span>
                                @endforeach
                                @foreach(range(6, 19) as $day)
                                <span class="py-0.5 rounded {{ $day === 15 ? 'bg-fm-primary text-white font-bold' : '' }}">{{ $day }}</span>
                                @endforeach
                            </div>
                            <div class="flex gap-1 justify-center mb-2">
                                @foreach(['09:00', '13:00', '16:00'] as $slot)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-semibold {{ $slot === '13:00' ? 'text-white' : 'bg-primary-50 text-fm-primary-dark' }}" @if($slot === '13:00') style="background:#F08A5D;" @endif>{{ $slot }}</span>
                                @endforeach
                            </div>
                            <div class="rounded-md bg-fm-dark text-white text-[10px] font-bold text-center py-1">Booking Teknisi</div>
                        </div>
                    </div>
                    <span class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-fm-primary border-4 border-white flex items-center justify-center shadow">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                </div>
            </div>
            <h3 class="font-extrabold text-fm-dark text-center mb-2" style="font-size:1.125rem;letter-spacing:-.02em;line-height:1.3;">5. Booking Teknisi Sesuai Jadwal</h3>
            <p class="body-md text-center">Pilih tanggal &amp; jam kunjungan, teknisi datang tepat waktu.</p>
        </li>
    </ol>

    <div class="max-w-5xl mx-auto">
        {{-- Keunggulan --}}
        <div class="bg-white/70 rounded-3xl p-8 sm:p-12 mb-16 border border-fm-primary/[.08]">
            <h2 class="display-md text-fm-dark text-center mb-8" style="font-size:1.5rem;">Keunggulan Sistem Pakar FIXMATE</h2>
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
            <a href="{{ route('diagnosis.create') }}" class="inline-flex items-center gap-2 bg-fm-primary text-white px-8 py-3.5 rounded-xl font-bold hover:bg-fm-primary-dark transition-all hover:-translate-y-0.5 hover:shadow-lg">
                Mulai Diagnosis Sekarang
            </a>
        </div>
    </div>
</div>
</div>
@endsection
