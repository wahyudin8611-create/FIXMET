@props(['devices'])

@php
$svgs = [
    // 0: AC & Pendingin
    '<svg viewBox="0 0 220 160" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="34" width="200" height="92" rx="16" stroke="white" stroke-width="3.5"/>
        <rect x="22" y="46" width="118" height="68" rx="8" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <line x1="32" y1="64" x2="132" y2="64" stroke="white" stroke-width="2" stroke-opacity=".35"/>
        <line x1="32" y1="78" x2="132" y2="78" stroke="white" stroke-width="2" stroke-opacity=".35"/>
        <line x1="32" y1="92" x2="132" y2="92" stroke="white" stroke-width="2" stroke-opacity=".35"/>
        <line x1="32" y1="106" x2="132" y2="106" stroke="white" stroke-width="2" stroke-opacity=".35"/>
        <circle cx="173" cy="80" r="32" stroke="white" stroke-width="3"/>
        <circle cx="173" cy="80" r="16" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <line x1="173" y1="48" x2="173" y2="112" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <line x1="141" y1="80" x2="205" y2="80" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <circle cx="30" cy="43" r="5" fill="white" fill-opacity=".65"/>
        <rect x="76" y="128" width="68" height="12" rx="6" stroke="white" stroke-width="2.5" stroke-opacity=".6"/>
        <line x1="85" y1="128" x2="85" y2="140" stroke="white" stroke-width="2" stroke-opacity=".4"/>
        <line x1="135" y1="128" x2="135" y2="140" stroke="white" stroke-width="2" stroke-opacity=".4"/>
    </svg>',

    // 1: Laptop & PC
    '<svg viewBox="0 0 220 170" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="25" y="12" width="170" height="110" rx="10" stroke="white" stroke-width="3.5"/>
        <rect x="36" y="22" width="148" height="90" rx="5" fill="white" fill-opacity=".07" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <circle cx="110" cy="17" r="3.5" fill="white" fill-opacity=".55"/>
        <line x1="52" y1="50" x2="168" y2="50" stroke="white" stroke-width="1.5" stroke-opacity=".3"/>
        <line x1="52" y1="64" x2="140" y2="64" stroke="white" stroke-width="1.5" stroke-opacity=".22"/>
        <line x1="52" y1="78" x2="155" y2="78" stroke="white" stroke-width="1.5" stroke-opacity=".22"/>
        <rect x="70" y="88" width="46" height="14" rx="4" fill="white" fill-opacity=".12" stroke="white" stroke-width="1" stroke-opacity=".3"/>
        <path d="M5 128 Q25 122 195 122 Q215 128 218 142 Q218 154 200 154 L20 154 Q2 154 2 142 Z" stroke="white" stroke-width="3"/>
        <rect x="30" y="130" width="160" height="14" rx="3" stroke="white" stroke-width="1" stroke-opacity=".25"/>
        <rect x="80" y="140" width="60" height="8" rx="3" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <line x1="25" y1="122" x2="195" y2="122" stroke="white" stroke-width="2.5" stroke-opacity=".7"/>
    </svg>',

    // 2: Kulkas
    '<svg viewBox="0 0 140 210" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="15" y="8" width="110" height="194" rx="16" stroke="white" stroke-width="3.5"/>
        <line x1="15" y1="82" x2="125" y2="82" stroke="white" stroke-width="2.5" stroke-opacity=".7"/>
        <line x1="108" y1="26" x2="108" y2="60" stroke="white" stroke-width="3.5" stroke-linecap="round"/>
        <line x1="108" y1="98" x2="108" y2="155" stroke="white" stroke-width="3.5" stroke-linecap="round"/>
        <line x1="70" y1="28" x2="70" y2="58" stroke="white" stroke-width="1.5" stroke-opacity=".45"/>
        <line x1="55" y1="43" x2="85" y2="43" stroke="white" stroke-width="1.5" stroke-opacity=".45"/>
        <line x1="59" y1="31" x2="81" y2="55" stroke="white" stroke-width="1.5" stroke-opacity=".45"/>
        <line x1="81" y1="31" x2="59" y2="55" stroke="white" stroke-width="1.5" stroke-opacity=".45"/>
        <circle cx="70" cy="43" r="4" fill="white" fill-opacity=".5"/>
        <rect x="28" y="92" width="62" height="22" rx="5" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <rect x="28" y="162" width="84" height="26" rx="6" stroke="white" stroke-width="2" stroke-opacity=".4"/>
        <line x1="38" y1="162" x2="38" y2="188" stroke="white" stroke-width="1" stroke-opacity=".25"/>
    </svg>',

    // 3: Mesin Cuci
    '<svg viewBox="0 0 170 190" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="12" y="15" width="146" height="162" rx="16" stroke="white" stroke-width="3.5"/>
        <rect x="22" y="24" width="126" height="26" rx="6" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <circle cx="36" cy="37" r="5" fill="white" fill-opacity=".5"/>
        <circle cx="54" cy="37" r="5" fill="white" fill-opacity=".3"/>
        <circle cx="72" cy="37" r="5" fill="white" fill-opacity=".15"/>
        <rect x="118" y="28" width="22" height="14" rx="3" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <circle cx="85" cy="120" r="52" stroke="white" stroke-width="3"/>
        <circle cx="85" cy="120" r="40" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <circle cx="85" cy="120" r="24" stroke="white" stroke-width="2" stroke-opacity=".35"/>
        <circle cx="85" cy="120" r="8" fill="white" fill-opacity=".25" stroke="white" stroke-width="2"/>
        <circle cx="85" cy="84" r="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/>
        <circle cx="85" cy="156" r="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/>
        <circle cx="49" cy="120" r="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/>
        <circle cx="121" cy="120" r="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/>
    </svg>',

    // 4: Smartphone
    '<svg viewBox="0 0 120 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="12" y="10" width="96" height="180" rx="22" stroke="white" stroke-width="3.5"/>
        <rect x="20" y="28" width="80" height="140" rx="8" fill="white" fill-opacity=".07" stroke="white" stroke-width="1.5" stroke-opacity=".3"/>
        <rect x="42" y="14" width="36" height="8" rx="4" stroke="white" stroke-width="1.5" stroke-opacity=".5"/>
        <circle cx="60" cy="18" r="3" fill="white" fill-opacity=".45"/>
        <line x1="30" y1="60" x2="90" y2="60" stroke="white" stroke-width="1.5" stroke-opacity=".25"/>
        <line x1="30" y1="74" x2="76" y2="74" stroke="white" stroke-width="1.5" stroke-opacity=".18"/>
        <line x1="30" y1="88" x2="82" y2="88" stroke="white" stroke-width="1.5" stroke-opacity=".18"/>
        <rect x="30" y="104" width="60" height="36" rx="6" fill="white" fill-opacity=".1" stroke="white" stroke-width="1.5" stroke-opacity=".3"/>
        <rect x="36" y="110" width="48" height="8" rx="3" fill="white" fill-opacity=".2"/>
        <rect x="36" y="122" width="30" height="8" rx="3" fill="white" fill-opacity=".12"/>
        <circle cx="60" cy="178" r="7" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <line x1="1" y1="70" x2="1" y2="90" stroke="white" stroke-width="3" stroke-linecap="round" stroke-opacity=".5"/>
        <line x1="1" y1="102" x2="1" y2="118" stroke="white" stroke-width="3" stroke-linecap="round" stroke-opacity=".5"/>
        <line x1="119" y1="80" x2="119" y2="102" stroke="white" stroke-width="3" stroke-linecap="round" stroke-opacity=".5"/>
    </svg>',

    // 5: Listrik Rumah
    '<svg viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 14 L62 90 L88 90 L80 166 L118 90 L92 90 Z" stroke="white" stroke-width="3.5" stroke-linejoin="round" fill="white" fill-opacity=".12"/>
        <circle cx="90" cy="90" r="78" stroke="white" stroke-width="2" stroke-opacity=".18"/>
        <circle cx="90" cy="90" r="62" stroke="white" stroke-width="1.5" stroke-opacity=".12"/>
        <line x1="22" y1="90" x2="36" y2="90" stroke="white" stroke-width="2" stroke-opacity=".3"/>
        <line x1="144" y1="90" x2="158" y2="90" stroke="white" stroke-width="2" stroke-opacity=".3"/>
        <line x1="90" y1="12" x2="90" y2="26" stroke="white" stroke-width="2" stroke-opacity=".3"/>
        <line x1="90" y1="154" x2="90" y2="168" stroke="white" stroke-width="2" stroke-opacity=".3"/>
        <line x1="38" y1="38" x2="48" y2="48" stroke="white" stroke-width="2" stroke-opacity=".3"/>
        <line x1="132" y1="132" x2="142" y2="142" stroke="white" stroke-width="2" stroke-opacity=".3"/>
    </svg>',

    // 6: Kendaraan
    '<svg viewBox="0 0 220 140" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M32 90 L50 55 Q60 38 78 36 L148 34 Q168 34 178 50 L196 90 Z" stroke="white" stroke-width="3.5" stroke-linejoin="round"/>
        <path d="M32 90 L20 92 Q10 94 10 104 L10 114 Q10 118 15 118 L32 118" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M196 90 L210 92 Q218 95 218 104 L218 114 Q218 118 212 118 L196 118" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M55 90 L65 90" stroke="white" stroke-width="2" stroke-opacity=".4"/>
        <path d="M163 90 L174 90" stroke="white" stroke-width="2" stroke-opacity=".4"/>
        <rect x="55" y="90" width="118" height="28" rx="0" stroke="white" stroke-width="0"/>
        <line x1="55" y1="90" x2="173" y2="90" stroke="white" stroke-width="2.5" stroke-opacity=".5"/>
        <line x1="32" y1="118" x2="65" y2="118" stroke="white" stroke-width="3" stroke-opacity=".7"/>
        <line x1="162" y1="118" x2="196" y2="118" stroke="white" stroke-width="3" stroke-opacity=".7"/>
        <circle cx="65" cy="118" r="18" stroke="white" stroke-width="3.5"/>
        <circle cx="65" cy="118" r="8" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <circle cx="162" cy="118" r="18" stroke="white" stroke-width="3.5"/>
        <circle cx="162" cy="118" r="8" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <path d="M78 36 L84 60 L148 60 L148 36" stroke="white" stroke-width="2" stroke-opacity=".3" stroke-linejoin="round"/>
        <line x1="117" y1="36" x2="116" y2="60" stroke="white" stroke-width="1.5" stroke-opacity=".3"/>
        <rect x="18" y="96" width="22" height="14" rx="4" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <rect x="188" y="96" width="14" height="14" rx="4" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
    </svg>',

    // 7: Elektronik Lainnya
    '<svg viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="54" y="40" width="92" height="92" rx="12" stroke="white" stroke-width="3.5"/>
        <rect x="68" y="54" width="64" height="64" rx="6" fill="white" fill-opacity=".08" stroke="white" stroke-width="1.5" stroke-opacity=".4"/>
        <line x1="80" y1="72" x2="80" y2="100" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="92" y1="72" x2="92" y2="100" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="104" y1="72" x2="104" y2="100" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="116" y1="72" x2="116" y2="100" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="80" y1="72" x2="116" y2="72" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="80" y1="84" x2="116" y2="84" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="80" y1="96" x2="116" y2="96" stroke="white" stroke-width="1.5" stroke-opacity=".35"/>
        <line x1="80" y1="100" x2="116" y2="100" stroke="white" stroke-width="1" stroke-opacity=".3"/>
        <line x1="100" y1="10" x2="100" y2="40" stroke="white" stroke-width="2.5" stroke-opacity=".5"/>
        <line x1="100" y1="132" x2="100" y2="162" stroke="white" stroke-width="2.5" stroke-opacity=".5"/>
        <line x1="20" y1="86" x2="54" y2="86" stroke="white" stroke-width="2.5" stroke-opacity=".5"/>
        <line x1="146" y1="86" x2="180" y2="86" stroke="white" stroke-width="2.5" stroke-opacity=".5"/>
        <circle cx="100" cy="8" r="5" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <circle cx="100" cy="164" r="5" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <circle cx="18" cy="86" r="5" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <circle cx="182" cy="86" r="5" stroke="white" stroke-width="2" stroke-opacity=".5"/>
        <circle cx="100" cy="86" r="6" fill="white" fill-opacity=".35"/>
    </svg>',
];
@endphp

<section id="etalase" class="l-section" style="background:#f5f5f7;" aria-labelledby="bento-heading">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">

        {{-- Header --}}
        <div class="text-center mb-14 reveal">
            <h2 id="bento-heading" class="font-bold tracking-[-0.025em] leading-tight text-[#1d1d1f] mb-4"
                style="font-size: clamp(2rem, 5vw, 3.25rem);">
                Apa yang rusak?<br>Kami bantu cari tahu.
            </h2>
            <p class="text-[#6e6e73] max-w-lg mx-auto text-lg font-light">
                Pilih kategori perangkat dan mulai diagnosis berbasis foto.
            </p>
        </div>

        @php
            $link = route('diagnosis.create');
            $desktopSpan = [
                0 => 'grid-column:span 2;grid-row:span 2;',
                5 => 'grid-column:span 2;',
            ];
        @endphp

        {{-- Desktop bento --}}
        <div class="hidden md:grid gap-4 reveal"
             style="grid-template-columns:repeat(4,1fr);grid-template-rows:280px 280px 240px;">
            @foreach($devices as $idx => $device)
            <a href="{{ $link }}"
               class="bento-card group block"
               style="{{ $desktopSpan[$idx] ?? '' }} background: {{ $device['gradient'] }};"
               aria-label="Diagnosis {{ $device['name'] }}"
            >
                {{-- SVG illustration --}}
                <div class="absolute inset-0 flex items-center justify-center" style="opacity:.42;pointer-events:none;" aria-hidden="true">
                    <div style="width:72%;max-width:200px;">
                        {!! $svgs[$idx] ?? '' !!}
                    </div>
                </div>

                {{-- Overlay gradient --}}
                <div class="bento-overlay absolute inset-0" aria-hidden="true"></div>

                {{-- Content --}}
                <div class="absolute inset-0 flex flex-col justify-end p-6">
                    <h3 class="text-white font-bold leading-tight" style="font-size:1.0625rem;">{{ $device['name'] }}</h3>
                    <p class="text-white/60 text-sm mt-1">{{ $device['example'] }}</p>
                    <span class="bento-link mt-3 inline-flex items-center gap-1 text-white/45 text-sm font-medium transition-all duration-300 group-hover:text-white/90 group-hover:gap-2">
                        Diagnosis sekarang <span aria-hidden="true">›</span>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Mobile horizontal scroll --}}
        <div class="md:hidden snap-scroll -mx-5 px-5 reveal" role="list">
            @foreach($devices as $idx => $device)
            <a href="{{ $link }}"
               class="bento-card group block"
               style="width:240px;height:300px;background: {{ $device['gradient'] }};"
               role="listitem"
               aria-label="Diagnosis {{ $device['name'] }}"
            >
                <div class="absolute inset-0 flex items-center justify-center" style="opacity:.42;pointer-events:none;" aria-hidden="true">
                    <div style="width:70%;">
                        {!! $svgs[$idx] ?? '' !!}
                    </div>
                </div>
                <div class="bento-overlay absolute inset-0" aria-hidden="true"></div>
                <div class="absolute inset-0 flex flex-col justify-end p-5">
                    <h3 class="text-white font-bold text-base">{{ $device['name'] }}</h3>
                    <p class="text-white/60 text-xs mt-1">{{ $device['example'] }}</p>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
