<section class="relative min-h-screen flex flex-col items-center justify-center text-center pt-20 pb-16 px-5 sm:px-8 overflow-hidden bg-white" aria-labelledby="hero-heading">

    {{-- Ambient background blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div style="position:absolute;top:-200px;left:50%;transform:translateX(-50%);width:800px;height:800px;background:radial-gradient(ellipse at center,rgba(0,113,227,.07) 0%,transparent 70%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-100px;left:10%;width:400px;height:400px;background:radial-gradient(ellipse at center,rgba(88,86,214,.05) 0%,transparent 70%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-80px;right:5%;width:300px;height:300px;background:radial-gradient(ellipse at center,rgba(0,113,227,.05) 0%,transparent 70%);border-radius:50%;"></div>
    </div>

    <div class="relative max-w-[780px] mx-auto">

        {{-- Eyebrow pill --}}
        <div class="reveal inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-blue-100 bg-blue-50 mb-7">
            <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3] animate-pulse" aria-hidden="true"></span>
            <span class="text-xs font-semibold text-[#0071e3] tracking-widest uppercase">Baru · Diagnosis berbasis foto</span>
        </div>

        {{-- Headline --}}
        <h1 id="hero-heading" class="reveal reveal-d1 font-bold leading-[1.04] tracking-[-0.03em] mb-6"
            style="font-size: clamp(2.5rem, 7vw, 5.25rem);">
            Foto masalahnya.<br>
            <span class="gradient-text">Pahami kerusakannya.</span>
        </h1>

        {{-- Sub --}}
        <p class="reveal reveal-d2 text-[#6e6e73] max-w-xl mx-auto leading-relaxed mb-10 font-light"
           style="font-size: clamp(1rem, 2vw, 1.1875rem);">
            FIXMATE menggabungkan analisis visual AI dan sistem pakar untuk menemukan
            kemungkinan kerusakan perangkatmu, lalu memandu perbaikan atau menghubungkanmu
            dengan teknisi terverifikasi.
        </p>

        {{-- CTAs --}}
        <div class="reveal reveal-d3 flex flex-wrap justify-center items-center gap-4 mb-20">
            @auth
            <a href="{{ route('user.diagnosis.create') }}" class="btn-pill btn-blue text-base px-7 py-3">Mulai Diagnosis</a>
            @else
            <a href="{{ route('register') }}" class="btn-pill btn-blue text-base px-7 py-3">Mulai Diagnosis</a>
            @endauth
            <a href="#cara-kerja" class="link-arrow text-base">Lihat cara kerja <span aria-hidden="true">›</span></a>
        </div>

        {{-- Product mockup --}}
        <div class="reveal reveal-d4 relative mx-auto" style="max-width: 680px;">
            <div class="hero-mock relative rounded-[28px] overflow-hidden shadow-[0_40px_80px_rgba(0,0,0,.18)]"
                 style="background: linear-gradient(160deg, #07090f 0%, #0d1a3e 50%, #100824 100%); border: 1px solid rgba(255,255,255,.06);">

                {{-- Window chrome --}}
                <div class="flex items-center justify-between px-6 pt-5 pb-3">
                    <div class="flex items-center gap-2">
                        <div style="width:10px;height:10px;border-radius:50%;background:rgba(239,68,68,.6);"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:rgba(234,179,8,.6);"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:rgba(34,197,94,.6);"></div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div style="width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.15);"></div>
                        <span style="font-size:11px;color:rgba(255,255,255,.3);font-family:monospace;">fixmate · ai diagnosis</span>
                    </div>
                    <div style="width:60px;"></div>
                </div>

                <div class="px-5 pb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Left: Upload zone --}}
                    <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:18px;overflow:hidden;">
                        <div class="flex flex-col items-center justify-center gap-3 p-5" style="aspect-ratio:4/3;">
                            <div style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg,#0071e3,#5856d6);display:flex;align-items:center;justify-content:center;">
                                <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p style="color:rgba(255,255,255,.85);font-size:13px;font-weight:500;">Analisis selesai</p>
                                <p style="color:rgba(255,255,255,.4);font-size:11px;margin-top:2px;">ac_unit_kompressor.jpg</p>
                            </div>
                            <div style="width:100%;background:rgba(255,255,255,.08);border-radius:99px;height:4px;">
                                <div style="width:100%;height:100%;background:linear-gradient(90deg,#0071e3,#5856d6);border-radius:99px;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Diagnosis result --}}
                    <div class="flex flex-col gap-3">
                        {{-- Top result --}}
                        <div style="background:rgba(0,113,227,.15);border:1px solid rgba(0,113,227,.28);border-radius:16px;padding:14px 16px;">
                            <div class="flex items-start justify-between" style="margin-bottom:8px;">
                                <div>
                                    <p style="color:#0071e3;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">Kecocokan Tertinggi</p>
                                    <p style="color:#fff;font-size:14px;font-weight:600;">Kompresor AC Rusak</p>
                                </div>
                                <span style="font-size:22px;font-weight:800;color:#0071e3;letter-spacing:-.03em;flex-shrink:0;margin-left:8px;">87%</span>
                            </div>
                            <div style="background:rgba(255,255,255,.08);border-radius:99px;height:4px;">
                                <div style="width:87%;height:100%;background:#0071e3;border-radius:99px;"></div>
                            </div>
                        </div>

                        {{-- Other possibilities --}}
                        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:12px 16px;">
                            <p style="color:rgba(255,255,255,.35);font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Kemungkinan lain</p>
                            <div style="display:flex;flex-direction:column;gap:7px;">
                                @foreach([['Freon habis','65%','65%'],['Filter kotor','42%','42%']] as [$name, $pct, $w])
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                    <span style="color:rgba(255,255,255,.65);font-size:12px;">{{ $name }}</span>
                                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                                        <div style="width:48px;background:rgba(255,255,255,.08);border-radius:99px;height:3px;">
                                            <div style="width:{{ $w }};height:100%;background:rgba(255,255,255,.3);border-radius:99px;"></div>
                                        </div>
                                        <span style="color:rgba(255,255,255,.4);font-size:11px;min-width:24px;text-align:right;">{{ $pct }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Risk badge --}}
                        <div style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);border-radius:16px;padding:10px 14px;display:flex;align-items:center;gap:10px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:rgba(239,68,68,.18);display:flex;align-items:center;justify-content:center;flex-shrink:0;" aria-hidden="true">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="rgba(252,165,165,1)" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="color:rgba(252,165,165,1);font-size:11px;font-weight:700;">Risiko: Tinggi</p>
                                <p style="color:rgba(255,255,255,.45);font-size:11px;">Disarankan memanggil teknisi</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Ambient glow --}}
            <div class="absolute pointer-events-none" aria-hidden="true"
                 style="inset:-60px;z-index:-1;opacity:.15;filter:blur(48px);background:radial-gradient(ellipse at 50% 100%,#0071e3 0%,transparent 65%);"></div>
        </div>

    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" aria-hidden="true">
        <span class="text-[10px] font-medium text-[#6e6e73] tracking-widest uppercase">Scroll</span>
        <svg class="w-4 h-4 text-[#6e6e73] animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

</section>
