@props(['features'])

<div id="fitur" aria-label="Fitur utama FIXMATE">
@foreach($features as $i => $feature)

@php
    $bg = match($feature['bg']) {
        'gray' => 'background:#f5f5f7',
        'dark' => 'background:#1d1d1f',
        default => 'background:#ffffff',
    };
    $isDark = $feature['bg'] === 'dark';
    $flip = $feature['flip'];
@endphp

<section
    class="l-section overflow-hidden"
    style="{{ $bg }};"
    aria-labelledby="feature-{{ $i }}-heading"
>
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Text block --}}
            <div class="{{ $flip ? 'md:order-last' : '' }} reveal {{ $flip ? 'reveal-d1' : '' }}">
                <p class="text-xs font-bold tracking-widest uppercase mb-4 {{ $isDark ? 'text-blue-400' : 'text-[#0071e3]' }}">
                    {{ $feature['label'] }}
                </p>
                <h2 id="feature-{{ $i }}-heading"
                    class="font-bold tracking-[-0.025em] leading-tight mb-5 {{ $isDark ? 'text-white' : 'text-[#1d1d1f]' }}"
                    style="font-size: clamp(1.875rem, 4vw, 2.75rem);">
                    {!! nl2br(e($feature['title'])) !!}
                </h2>
                <p class="leading-relaxed mb-6 font-light {{ $isDark ? 'text-white/70' : 'text-[#6e6e73]' }}"
                   style="font-size: 1.0625rem;">
                    {{ $feature['body'] }}
                </p>
                <div class="flex items-start gap-2.5 rounded-xl px-4 py-3"
                     style="{{ $isDark ? 'background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);' : 'background:#f0f7ff;border:1px solid #dbeafe;' }}">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 {{ $isDark ? 'text-blue-400' : 'text-blue-500' }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-xs leading-relaxed {{ $isDark ? 'text-white/50' : 'text-blue-700' }}">{{ $feature['note'] }}</p>
                </div>
            </div>

            {{-- Visual block --}}
            <div class="{{ $flip ? '' : 'md:order-last' }} reveal {{ $flip ? '' : 'reveal-d1' }}">
                @if($i === 0)
                {{-- Feature 1: Photo upload visual --}}
                <div class="feature-visual" style="background:linear-gradient(145deg,#0a0f1e,#0d1a3e); padding: 28px; aspect-ratio: 4/3;">
                    <div style="border-radius:16px;overflow:hidden;height:100%;display:flex;flex-direction:column;gap:12px;">
                        {{-- Upload area --}}
                        <div style="flex:1;border:2px dashed rgba(0,113,227,.4);border-radius:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;background:rgba(0,113,227,.05);">
                            <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#0071e3,#5856d6);display:flex;align-items:center;justify-content:center;" aria-hidden="true">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            </div>
                            <p style="color:rgba(255,255,255,.5);font-size:12px;text-align:center;">Seret foto kerusakan ke sini<br><span style="color:rgba(0,113,227,.8);">atau pilih file</span></p>
                        </div>
                        {{-- Progress bar --}}
                        <div style="background:rgba(255,255,255,.06);border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:rgba(0,113,227,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;" aria-hidden="true">
                                <svg width="16" height="16" fill="rgba(0,113,227,1)" viewBox="0 0 20 20"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16M14 14l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                            </div>
                            <div style="flex:1;">
                                <p style="color:rgba(255,255,255,.7);font-size:12px;font-weight:500;">ac_foto.jpg</p>
                                <div style="background:rgba(255,255,255,.08);border-radius:99px;height:3px;margin-top:5px;">
                                    <div style="width:78%;height:100%;background:#0071e3;border-radius:99px;"></div>
                                </div>
                            </div>
                            <span style="color:#0071e3;font-size:11px;font-weight:600;">78%</span>
                        </div>
                    </div>
                </div>

                @elseif($i === 1)
                {{-- Feature 2: Expert system reasoning tree --}}
                <div class="feature-visual" style="background:#f0f4ff; padding: 28px; aspect-ratio: 4/3;">
                    <div style="height:100%;display:flex;flex-direction:column;gap:10px;justify-content:center;">
                        <p style="font-size:11px;font-weight:700;color:#0071e3;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Jalur Logika Sistem Pakar</p>
                        @foreach([
                            ['AC tidak dingin', '#1d1d1f', '#e8f0fe', '#3b82f6', '✓'],
                            ['Kompresor berbunyi keras', '#1d1d1f', '#e8f0fe', '#3b82f6', '✓'],
                            ['Freon sudah dicek (tidak habis)', '#6e6e73', '#f5f5f7', '#9ca3af', '×'],
                            ['Filter bersih', '#6e6e73', '#f5f5f7', '#9ca3af', '×'],
                        ] as [$text, $txtColor, $bg, $dotColor, $icon])
                        <div style="display:flex;align-items:center;gap:10px;background:{{ $bg }};border-radius:10px;padding:9px 12px;">
                            <span style="width:20px;height:20px;border-radius:50%;background:{{ $dotColor }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;color:#fff;font-weight:700;">{{ $icon }}</span>
                            <span style="color:{{ $txtColor }};font-size:13px;">{{ $text }}</span>
                        </div>
                        @endforeach
                        <div style="height:1px;background:#dbeafe;margin:4px 0;" aria-hidden="true"></div>
                        <div style="background:linear-gradient(135deg,#0071e3,#5856d6);border-radius:12px;padding:12px 14px;display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <p style="color:#fff;font-size:12px;font-weight:700;">→ Kompresor AC Rusak</p>
                                <p style="color:rgba(255,255,255,.65);font-size:11px;margin-top:2px;">Berdasarkan 2 dari 4 gejala terpenuhi</p>
                            </div>
                            <span style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-.03em;">87%</span>
                        </div>
                    </div>
                </div>

                @elseif($i === 2)
                {{-- Feature 3: Step by step repair guide --}}
                <div class="feature-visual" style="background:linear-gradient(145deg,#0a0a0a,#1a1a2e); padding: 28px; aspect-ratio: 4/3;">
                    <div style="height:100%;display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <p style="color:rgba(255,255,255,.85);font-size:13px;font-weight:600;">Panduan Perbaikan</p>
                            <span style="background:rgba(239,68,68,.2);color:rgba(252,165,165,1);font-size:10px;font-weight:700;padding:2px 8px;border-radius:99px;border:1px solid rgba(239,68,68,.3);">HIGH RISK</span>
                        </div>
                        @foreach([
                            ['1', 'Matikan AC dan cabut dari listrik', false, '#22c55e'],
                            ['2', 'Tunggu 15 menit sebelum menyentuh', false, '#22c55e'],
                            ['3', 'Periksa visual kabel kompresor', false, '#22c55e'],
                            ['4', 'Jika ada gosong → hubungi teknisi', true, '#f59e0b'],
                        ] as [$num, $step, $warn, $color])
                        <div style="display:flex;align-items:flex-start;gap:10px;background:rgba(255,255,255,.04);border-radius:10px;padding:9px 12px;{{ $warn ? 'border:1px solid rgba(245,158,11,.25);' : '' }}">
                            <span style="width:20px;height:20px;border-radius:50%;background:{{ $color }};color:#000;font-size:11px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">{{ $num }}</span>
                            <p style="color:{{ $warn ? 'rgba(253,230,138,1)' : 'rgba(255,255,255,.75)' }};font-size:12px;line-height:1.5;">{{ $step }}</p>
                        </div>
                        @endforeach
                        <div style="margin-top:auto;background:rgba(0,113,227,.15);border:1px solid rgba(0,113,227,.25);border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
                            <span style="color:rgba(255,255,255,.7);font-size:12px;">Atau hubungi teknisi terverifikasi</span>
                            <span style="color:#0071e3;font-size:12px;font-weight:600;">Cari teknisi ›</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endforeach
</div>
