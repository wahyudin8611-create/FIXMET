<section class="l-section dark-section relative overflow-hidden" aria-labelledby="cta-heading">

    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div style="position:absolute;top:-150px;left:-150px;width:500px;height:500px;background:radial-gradient(ellipse at center,rgba(61,139,122,.12) 0%,transparent 65%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-100px;right:-80px;width:400px;height:400px;background:radial-gradient(ellipse at center,rgba(226,184,91,.08) 0%,transparent 65%);border-radius:50%;"></div>
        {{-- Circuit pattern --}}
        <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                    <circle cx="30" cy="30" r="1" fill="white"/>
                    <path d="M30 0v15M30 45v15M0 30h15M45 30h15" stroke="white" stroke-width=".5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-pattern)"/>
        </svg>
    </div>

    <div class="relative max-w-6xl mx-auto px-5 sm:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left text --}}
            <div class="reveal">
                <p class="eyebrow text-fm-accent mb-6">Mulai Sekarang</p>
                <h2 id="cta-heading" class="display-xl text-white mb-6"
                    style="font-size: clamp(2rem, 5vw, 3.25rem);">
                    Perangkatmu bermasalah?<br>Mulai dari satu foto.
                </h2>
                <p class="max-w-md mb-9" style="font-size:1.125rem;line-height:1.75;color:rgba(255,255,255,.45);">
                    Diagnosis cerdas, panduan perbaikan lengkap, dan teknisi terverifikasi — semua dalam satu platform.
                </p>

                <div class="flex flex-wrap gap-4 mb-6">
                    @auth
                    <a href="{{ route('user.diagnosis.create') }}" class="btn-accent text-base px-8 py-3.5">Mulai Diagnosis</a>
                    @else
                    <a href="{{ route('register') }}" class="btn-accent text-base px-8 py-3.5">Mulai Diagnosis</a>
                    @endauth
                    <a href="{{ route('register.technician') }}" class="btn-outline-light text-base px-8 py-3.5">Daftar Teknisi</a>
                </div>

                <p style="font-size:.8125rem;color:rgba(255,255,255,.22);">
                    Gratis untuk pengguna. Teknisi mendaftar dan menunggu verifikasi tim kami.
                </p>
            </div>

            {{-- Right: Abstract map/coverage illustration --}}
            <div class="reveal reveal-d2 hidden lg:block">
                <div class="rounded-2xl overflow-hidden p-8" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);">
                    <div class="space-y-4">
                        {{-- Coverage stats --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-xl p-4" style="background:rgba(61,139,122,.1);border:1px solid rgba(61,139,122,.15);">
                                <p class="text-fm-primary-light font-extrabold" style="font-size:1.5rem;letter-spacing:-.04em;font-variant-numeric:tabular-nums;">25+</p>
                                <p class="mt-1.5" style="font-size:.8125rem;color:rgba(255,255,255,.45);">Teknisi Terverifikasi</p>
                            </div>
                            <div class="rounded-xl p-4" style="background:rgba(226,184,91,.1);border:1px solid rgba(226,184,91,.15);">
                                <p class="text-fm-accent font-extrabold" style="font-size:1.5rem;letter-spacing:-.04em;font-variant-numeric:tabular-nums;">10+</p>
                                <p class="mt-1.5" style="font-size:.8125rem;color:rgba(255,255,255,.45);">Kategori Perangkat</p>
                            </div>
                        </div>
                        <div class="rounded-xl p-4" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);">
                            <p class="font-semibold mb-3" style="font-size:.875rem;color:rgba(255,255,255,.65);letter-spacing:-.01em;">Area Layanan</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan'] as $city)
                                <span class="px-3 py-1.5 rounded-full font-medium" style="font-size:.75rem;color:rgba(255,255,255,.55);background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);">{{ $city }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="rounded-xl p-4" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-fm-primary/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-fm-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold" style="font-size:.875rem;color:rgba(255,255,255,.75);letter-spacing:-.01em;">Respons Cepat</p>
                                    <p style="font-size:.8125rem;color:rgba(255,255,255,.38);">Rata-rata teknisi merespons dalam 30 menit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
