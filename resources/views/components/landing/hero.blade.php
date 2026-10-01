<section class="relative min-h-[600px] lg:min-h-[680px] flex items-center overflow-hidden" aria-labelledby="hero-heading">

    {{-- Background --}}
    <div class="absolute inset-0 hero-gradient" aria-hidden="true">
        {{-- Abstract circuit/repair pattern --}}
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-pattern" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <circle cx="40" cy="40" r="1.5" fill="white"/>
                    <path d="M40 0v20M40 60v20M0 40h20M60 40h20" stroke="white" stroke-width=".5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-pattern)"/>
        </svg>
        {{-- Glow accents --}}
        <div style="position:absolute;top:10%;right:15%;width:500px;height:500px;background:radial-gradient(ellipse at center,rgba(61,139,122,.15) 0%,transparent 70%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-10%;left:5%;width:400px;height:400px;background:radial-gradient(ellipse at center,rgba(226,184,91,.08) 0%,transparent 70%);border-radius:50%;"></div>
    </div>

    {{-- Content --}}
    <div class="relative max-w-7xl mx-auto px-5 sm:px-8 py-20 lg:py-28 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Left text --}}
            <div>
                {{-- Eyebrow --}}
                <div class="reveal inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/[.08] border border-white/[.12] mb-8">
                    <span class="w-1.5 h-1.5 rounded-full bg-fm-accent animate-pulse" aria-hidden="true"></span>
                    <span class="eyebrow text-fm-accent">Platform diagnosis perangkat</span>
                </div>

                <h1 id="hero-heading" class="reveal reveal-d1 display-xl text-white mb-6"
                    style="font-size: clamp(2.25rem, 5.5vw, 3.75rem);">
                    Dari perangkat rusak hingga perbaikan —
                    <span class="text-fm-accent">kami bantu semuanya</span>
                </h1>

                {{-- Bullet points --}}
                <div class="reveal reveal-d2 space-y-3.5 mb-9">
                    @foreach(['Diagnosis cerdas berbasis foto & sistem pakar', 'Panduan perbaikan langkah demi langkah', 'Teknisi terverifikasi siap dipanggil'] as $point)
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-fm-primary/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-fm-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-white/75 font-medium" style="font-size:.9375rem;letter-spacing:-.005em;">{{ $point }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- CTAs --}}
                <div class="reveal reveal-d3 flex flex-wrap items-center gap-4 mb-10">
                    @auth
                    <a href="{{ route('user.diagnosis.create') }}" class="btn-accent text-base px-8 py-3.5">Mulai Diagnosis</a>
                    @else
                    <a href="{{ route('register') }}" class="btn-accent text-base px-8 py-3.5">Mulai Diagnosis</a>
                    @endauth
                    <a href="{{ route('register.technician') }}" class="btn-outline-light text-base px-8 py-3.5">Daftar Teknisi</a>
                </div>

                {{-- Trust badge --}}
                <div class="reveal reveal-d4 inline-flex items-center gap-3 bg-white/[.06] rounded-xl px-4 py-3 border border-white/[.08]">
                    <div class="flex gap-0.5">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-fm-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <div>
                        <span class="text-white font-bold" style="font-size:.875rem;font-variant-numeric:tabular-nums;">4.9</span>
                        <span class="text-white/45 ml-1" style="font-size:.8125rem;">dari 500+ ulasan</span>
                    </div>
                </div>
            </div>

            {{-- Right: Product mockup --}}
            <div class="reveal reveal-d3 hidden lg:block">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl"
                     style="background: linear-gradient(160deg, #0f1923 0%, #1a2f3e 50%, #0f1923 100%); border: 1px solid rgba(255,255,255,.06);">

                    {{-- Window chrome --}}
                    <div class="flex items-center justify-between px-5 pt-4 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/60"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/60"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-400/60"></div>
                        </div>
                        <span class="text-[11px] text-white/25 font-mono">fixmet.id/diagnosis</span>
                        <div class="w-14"></div>
                    </div>

                    <div class="px-5 pb-5 grid grid-cols-2 gap-3">
                        {{-- Upload zone --}}
                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);">
                            <div class="flex flex-col items-center justify-center gap-3 p-5" style="aspect-ratio:4/3;">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#3D8B7A,#5BA897);">
                                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-white/85 text-xs font-medium">Analisis selesai</p>
                                    <p class="text-white/35 text-[10px] mt-0.5">ac_kompressor.jpg</p>
                                </div>
                                <div class="w-full rounded-full h-1" style="background:rgba(255,255,255,.08);">
                                    <div class="h-full rounded-full" style="width:100%;background:linear-gradient(90deg,#3D8B7A,#5BA897);"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Diagnosis result --}}
                        <div class="flex flex-col gap-2.5">
                            <div class="rounded-xl p-3.5" style="background:rgba(61,139,122,.15);border:1px solid rgba(61,139,122,.28);">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-fm-primary-light text-[9px] font-bold uppercase tracking-wide mb-1">Kecocokan Tertinggi</p>
                                        <p class="text-white text-[13px] font-semibold">Kompresor AC Rusak</p>
                                    </div>
                                    <span class="text-xl font-extrabold text-fm-primary-light">87%</span>
                                </div>
                                <div class="rounded-full h-1" style="background:rgba(255,255,255,.08);">
                                    <div class="h-full rounded-full bg-fm-primary" style="width:87%;"></div>
                                </div>
                            </div>

                            <div class="rounded-xl p-3" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);">
                                <p class="text-white/30 text-[9px] font-semibold uppercase tracking-wide mb-2">Kemungkinan lain</p>
                                @foreach([['Freon habis','65%'],['Filter kotor','42%']] as [$name, $pct])
                                <div class="flex items-center justify-between gap-2 {{ !$loop->last ? 'mb-1.5' : '' }}">
                                    <span class="text-white/60 text-[11px]">{{ $name }}</span>
                                    <span class="text-white/35 text-[10px]">{{ $pct }}</span>
                                </div>
                                @endforeach
                            </div>

                            <div class="rounded-xl p-3 flex items-center gap-2.5" style="background:rgba(226,184,91,.1);border:1px solid rgba(226,184,91,.2);">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(226,184,91,.15);">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="#E2B85B" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-fm-accent text-[10px] font-bold">Risiko: Tinggi</p>
                                    <p class="text-white/40 text-[10px]">Disarankan memanggil teknisi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ambient glow --}}
                <div class="absolute pointer-events-none" aria-hidden="true"
                     style="inset:-60px;z-index:-1;opacity:.12;filter:blur(48px);background:radial-gradient(ellipse at 50% 100%,#3D8B7A 0%,transparent 65%);"></div>
            </div>
        </div>
    </div>
</section>
