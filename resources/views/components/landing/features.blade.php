@props(['features'])

{{-- Features strip: 4 icons in a row like Maverick --}}
<section id="layanan" class="bg-white border-b border-black/[.04]" aria-label="Keunggulan FIXMET">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            @php
                $advantages = [
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'title' => 'Diagnosis Akurat', 'desc' => 'Sistem pakar berbasis aturan dengan transparansi penuh — kamu tahu mengapa diagnosis ini muncul.', 'color' => '#3D8B7A'],
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Teknisi Terverifikasi', 'desc' => 'Setiap teknisi melewati proses verifikasi. Kerjaan rapi, tarif transparan.', 'color' => '#2A6356'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Proses Cepat', 'desc' => 'Dari foto sampai diagnosis dalam hitungan menit. Tidak perlu antri atau menunggu.', 'color' => '#E2B85B'],
                    ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'title' => 'Panduan Lengkap', 'desc' => 'Perbaikan mandiri dengan panduan bertingkat. Label risiko membantu kamu memutuskan.', 'color' => '#5BA897'],
                ];
            @endphp

            @foreach($advantages as $idx => $adv)
            <div class="reveal reveal-d{{ $idx + 1 }} text-center">
                <div class="feature-icon-box mx-auto mb-5" style="background: {{ $adv['color'] }}12;">
                    <svg class="w-6 h-6" style="color: {{ $adv['color'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $adv['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-fm-dark mb-2" style="font-size:.9375rem;letter-spacing:-.02em;">{{ $adv['title'] }}</h3>
                <p class="body-sm max-w-[220px] mx-auto">{{ $adv['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Detailed feature sections --}}
<div aria-label="Fitur detail FIXMET">
@foreach($features as $i => $feature)
@php
    $bgMap = ['white' => '#FFFFFF', 'gray' => '#F5F6F3', 'dark' => '#1A2332'];
    $bg = $bgMap[$feature['bg']] ?? '#FFFFFF';
    $isDark = $feature['bg'] === 'dark';
    $flip = $feature['flip'];
@endphp

<section class="l-section overflow-hidden" style="background:{{ $bg }};" aria-labelledby="feature-{{ $i }}-heading">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Text --}}
            <div class="{{ $flip ? 'md:order-last' : '' }} reveal {{ $flip ? 'reveal-d1' : '' }}">
                <p class="eyebrow mb-5 {{ $isDark ? 'text-fm-accent' : 'text-fm-primary' }}">
                    {{ $feature['label'] }}
                </p>
                <h2 id="feature-{{ $i }}-heading"
                    class="display-lg mb-5 {{ $isDark ? 'text-white' : 'text-fm-dark' }}"
                    style="font-size: clamp(1.75rem, 4vw, 2.5rem);">
                    {!! nl2br(e($feature['title'])) !!}
                </h2>
                <p class="body-lg mb-7 {{ $isDark ? 'text-white/60' : '' }}">
                    {{ $feature['body'] }}
                </p>
                <div class="flex items-start gap-2.5 rounded-xl px-4 py-3.5"
                     style="{{ $isDark ? 'background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);' : 'background:#EDF5F0;border:1px solid #D1E7D9;' }}">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 {{ $isDark ? 'text-fm-accent' : 'text-fm-primary' }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="{{ $isDark ? 'text-white/45' : 'text-fm-primary' }}" style="font-size:.8125rem;line-height:1.6;">{{ $feature['note'] }}</p>
                </div>
            </div>

            {{-- Visual --}}
            <div class="{{ $flip ? '' : 'md:order-last' }} reveal {{ $flip ? '' : 'reveal-d1' }}">
                @if($i === 0)
                <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(145deg,#0f1923,#1a2f3e); padding: 28px; aspect-ratio: 4/3;">
                    <div style="border-radius:16px;overflow:hidden;height:100%;display:flex;flex-direction:column;gap:12px;">
                        <div style="flex:1;border:2px dashed rgba(61,139,122,.4);border-radius:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;background:rgba(61,139,122,.05);">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#3D8B7A,#5BA897);">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p style="color:rgba(255,255,255,.5);font-size:12px;text-align:center;">Seret foto kerusakan ke sini<br><span style="color:rgba(61,139,122,.8);">atau pilih file</span></p>
                        </div>
                        <div style="background:rgba(255,255,255,.06);border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(61,139,122,.15);">
                                <svg width="16" height="16" fill="#3D8B7A" viewBox="0 0 20 20"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16M14 14l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                            </div>
                            <div style="flex:1;">
                                <p style="color:rgba(255,255,255,.7);font-size:12px;font-weight:500;">ac_foto.jpg</p>
                                <div style="background:rgba(255,255,255,.08);border-radius:99px;height:3px;margin-top:5px;">
                                    <div style="width:78%;height:100%;background:#3D8B7A;border-radius:99px;"></div>
                                </div>
                            </div>
                            <span style="color:#3D8B7A;font-size:11px;font-weight:600;">78%</span>
                        </div>
                    </div>
                </div>
                @elseif($i === 1)
                <div class="rounded-2xl overflow-hidden" style="background:#EDF5F0; padding: 28px; aspect-ratio: 4/3;">
                    <div style="height:100%;display:flex;flex-direction:column;gap:10px;justify-content:center;">
                        <p style="font-size:11px;font-weight:700;color:#3D8B7A;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Jalur Logika Sistem Pakar</p>
                        @foreach([
                            ['AC tidak dingin', '#1F2937', '#E8F0EB', '#3D8B7A', '✓'],
                            ['Kompresor berbunyi keras', '#1F2937', '#E8F0EB', '#3D8B7A', '✓'],
                            ['Freon sudah dicek (tidak habis)', '#6B7280', '#F5F6F3', '#9CA3AF', '×'],
                            ['Filter bersih', '#6B7280', '#F5F6F3', '#9CA3AF', '×'],
                        ] as [$text, $txtColor, $bg, $dotColor, $icon])
                        <div style="display:flex;align-items:center;gap:10px;background:{{ $bg }};border-radius:10px;padding:9px 12px;">
                            <span style="width:20px;height:20px;border-radius:50%;background:{{ $dotColor }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;color:#fff;font-weight:700;">{{ $icon }}</span>
                            <span style="color:{{ $txtColor }};font-size:13px;">{{ $text }}</span>
                        </div>
                        @endforeach
                        <div style="height:1px;background:#D1E7D9;margin:4px 0;"></div>
                        <div style="background:linear-gradient(135deg,#3D8B7A,#2A6356);border-radius:12px;padding:12px 14px;display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <p style="color:#fff;font-size:12px;font-weight:700;">→ Kompresor AC Rusak</p>
                                <p style="color:rgba(255,255,255,.65);font-size:11px;margin-top:2px;">2 dari 4 gejala terpenuhi</p>
                            </div>
                            <span style="font-size:20px;font-weight:800;color:#fff;">87%</span>
                        </div>
                    </div>
                </div>
                @elseif($i === 2)
                <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(145deg,#0f1214,#1a2332); padding: 28px; aspect-ratio: 4/3;">
                    <div style="height:100%;display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <p style="color:rgba(255,255,255,.85);font-size:13px;font-weight:600;">Panduan Perbaikan</p>
                            <span style="background:rgba(226,184,91,.15);color:#E2B85B;font-size:10px;font-weight:700;padding:2px 8px;border-radius:99px;border:1px solid rgba(226,184,91,.25);">HIGH RISK</span>
                        </div>
                        @foreach([
                            ['1', 'Matikan AC dan cabut dari listrik', false, '#3D8B7A'],
                            ['2', 'Tunggu 15 menit sebelum menyentuh', false, '#3D8B7A'],
                            ['3', 'Periksa visual kabel kompresor', false, '#3D8B7A'],
                            ['4', 'Jika ada gosong → hubungi teknisi', true, '#E2B85B'],
                        ] as [$num, $step, $warn, $color])
                        <div style="display:flex;align-items:flex-start;gap:10px;background:rgba(255,255,255,.04);border-radius:10px;padding:9px 12px;{{ $warn ? 'border:1px solid rgba(226,184,91,.25);' : '' }}">
                            <span style="width:20px;height:20px;border-radius:50%;background:{{ $color }};color:{{ $warn ? '#1A2332' : '#fff' }};font-size:11px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">{{ $num }}</span>
                            <p style="color:{{ $warn ? '#E2B85B' : 'rgba(255,255,255,.75)' }};font-size:12px;line-height:1.5;">{{ $step }}</p>
                        </div>
                        @endforeach
                        <div style="margin-top:auto;background:rgba(61,139,122,.12);border:1px solid rgba(61,139,122,.2);border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
                            <span style="color:rgba(255,255,255,.7);font-size:12px;">Atau hubungi teknisi terverifikasi</span>
                            <span style="color:#5BA897;font-size:12px;font-weight:600;">Cari teknisi ›</span>
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
