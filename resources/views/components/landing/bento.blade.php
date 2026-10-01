@props(['devices'])

@php
$svgs = [
    '<svg viewBox="0 0 220 160" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="34" width="200" height="92" rx="16" stroke="white" stroke-width="3.5"/><rect x="22" y="46" width="118" height="68" rx="8" stroke="white" stroke-width="1.5" stroke-opacity=".4"/><line x1="32" y1="64" x2="132" y2="64" stroke="white" stroke-width="2" stroke-opacity=".35"/><line x1="32" y1="78" x2="132" y2="78" stroke="white" stroke-width="2" stroke-opacity=".35"/><line x1="32" y1="92" x2="132" y2="92" stroke="white" stroke-width="2" stroke-opacity=".35"/><circle cx="173" cy="80" r="32" stroke="white" stroke-width="3"/><circle cx="173" cy="80" r="16" stroke="white" stroke-width="2" stroke-opacity=".5"/></svg>',
    '<svg viewBox="0 0 220 170" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="25" y="12" width="170" height="110" rx="10" stroke="white" stroke-width="3.5"/><rect x="36" y="22" width="148" height="90" rx="5" fill="white" fill-opacity=".07" stroke="white" stroke-width="1.5" stroke-opacity=".35"/><circle cx="110" cy="17" r="3.5" fill="white" fill-opacity=".55"/><path d="M5 128 Q25 122 195 122 Q215 128 218 142 Q218 154 200 154 L20 154 Q2 154 2 142 Z" stroke="white" stroke-width="3"/></svg>',
    '<svg viewBox="0 0 140 210" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="15" y="8" width="110" height="194" rx="16" stroke="white" stroke-width="3.5"/><line x1="15" y1="82" x2="125" y2="82" stroke="white" stroke-width="2.5" stroke-opacity=".7"/><line x1="108" y1="26" x2="108" y2="60" stroke="white" stroke-width="3.5" stroke-linecap="round"/><line x1="108" y1="98" x2="108" y2="155" stroke="white" stroke-width="3.5" stroke-linecap="round"/></svg>',
    '<svg viewBox="0 0 170 190" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="15" width="146" height="162" rx="16" stroke="white" stroke-width="3.5"/><rect x="22" y="24" width="126" height="26" rx="6" stroke="white" stroke-width="1.5" stroke-opacity=".4"/><circle cx="85" cy="120" r="52" stroke="white" stroke-width="3"/><circle cx="85" cy="120" r="40" stroke="white" stroke-width="1.5" stroke-opacity=".4"/><circle cx="85" cy="120" r="8" fill="white" fill-opacity=".25" stroke="white" stroke-width="2"/></svg>',
    '<svg viewBox="0 0 120 200" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="10" width="96" height="180" rx="22" stroke="white" stroke-width="3.5"/><rect x="20" y="28" width="80" height="140" rx="8" fill="white" fill-opacity=".07" stroke="white" stroke-width="1.5" stroke-opacity=".3"/><rect x="42" y="14" width="36" height="8" rx="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/><circle cx="60" cy="178" r="7" stroke="white" stroke-width="2" stroke-opacity=".5"/></svg>',
    '<svg viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 14 L62 90 L88 90 L80 166 L118 90 L92 90 Z" stroke="white" stroke-width="3.5" stroke-linejoin="round" fill="white" fill-opacity=".12"/><circle cx="90" cy="90" r="78" stroke="white" stroke-width="2" stroke-opacity=".18"/></svg>',
    '<svg viewBox="0 0 220 140" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M32 90 L50 55 Q60 38 78 36 L148 34 Q168 34 178 50 L196 90 Z" stroke="white" stroke-width="3.5" stroke-linejoin="round"/><circle cx="65" cy="118" r="18" stroke="white" stroke-width="3.5"/><circle cx="162" cy="118" r="18" stroke="white" stroke-width="3.5"/><line x1="32" y1="118" x2="196" y2="118" stroke="white" stroke-width="3" stroke-opacity=".5"/></svg>',
    '<svg viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="54" y="40" width="92" height="92" rx="12" stroke="white" stroke-width="3.5"/><rect x="68" y="54" width="64" height="64" rx="6" fill="white" fill-opacity=".08" stroke="white" stroke-width="1.5" stroke-opacity=".4"/><circle cx="100" cy="86" r="6" fill="white" fill-opacity=".35"/><line x1="100" y1="10" x2="100" y2="40" stroke="white" stroke-width="2.5" stroke-opacity=".5"/><line x1="100" y1="132" x2="100" y2="162" stroke="white" stroke-width="2.5" stroke-opacity=".5"/><line x1="20" y1="86" x2="54" y2="86" stroke="white" stroke-width="2.5" stroke-opacity=".5"/><line x1="146" y1="86" x2="180" y2="86" stroke="white" stroke-width="2.5" stroke-opacity=".5"/></svg>',
];

$calmGradients = [
    'linear-gradient(160deg,#1A3A4A 0%,#2A5A6A 100%)',
    'linear-gradient(160deg,#1E293B 0%,#334155 100%)',
    'linear-gradient(160deg,#1A3A3A 0%,#2D6A5A 100%)',
    'linear-gradient(160deg,#1A3345 0%,#2A5560 100%)',
    'linear-gradient(160deg,#2D2B4A 0%,#4A4578 100%)',
    'linear-gradient(160deg,#3A2E1A 0%,#6B5530 100%)',
    'linear-gradient(160deg,#3A1A1A 0%,#6B3030 100%)',
    'linear-gradient(160deg,#252530 0%,#404050 100%)',
];
@endphp

<section id="etalase" class="l-section" style="background:#F5F6F3;" aria-labelledby="bento-heading">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">

        {{-- Header --}}
        <div class="text-center mb-14 reveal">
            <p class="eyebrow text-fm-primary mb-4">Perangkat yang Didukung</p>
            <h2 id="bento-heading" class="display-lg text-fm-dark mb-4"
                style="font-size: clamp(2rem, 4.5vw, 3rem);">
                Perangkat apa yang rusak?
            </h2>
            <p class="body-lg max-w-lg mx-auto">
                Pilih kategori perangkat dan mulai diagnosis.
            </p>
        </div>

        @php $link = auth()->check() ? route('user.diagnosis.create') : route('register'); @endphp

        {{-- Grid: 4 columns --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 reveal">
            @foreach($devices as $idx => $device)
            <a href="{{ $link }}"
               class="bento-card group block relative overflow-hidden rounded-2xl"
               style="background: {{ $calmGradients[$idx] ?? $calmGradients[0] }}; {{ $idx < 2 ? 'grid-row: span 1;' : '' }}"
               aria-label="Diagnosis {{ $device['name'] }}"
            >
                <div class="aspect-[3/4] sm:aspect-[4/3] flex flex-col">
                    {{-- SVG --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-[.15] pointer-events-none" aria-hidden="true">
                        <div style="width:60%;max-width:160px;">{!! $svgs[$idx] ?? '' !!}</div>
                    </div>

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent" aria-hidden="true"></div>

                    {{-- Content --}}
                    <div class="relative mt-auto p-4 sm:p-5">
                        <h3 class="text-white font-bold leading-tight" style="font-size:clamp(.8125rem,2vw,.9375rem);letter-spacing:-.01em;">{{ $device['name'] }}</h3>
                        <p class="text-white/45 mt-1" style="font-size:.75rem;line-height:1.5;">{{ $device['example'] }}</p>
                        <span class="mt-3 inline-flex items-center gap-1 text-white/35 font-semibold transition-all duration-300 group-hover:text-fm-accent group-hover:gap-2" style="font-size:.75rem;letter-spacing:.02em;">
                            Diagnosis <span aria-hidden="true">→</span>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
