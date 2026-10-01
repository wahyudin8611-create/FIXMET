<section id="cara-kerja" class="l-section bg-white" aria-labelledby="how-heading">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        {{-- Header --}}
        <div class="text-center mb-16 reveal">
            <p class="text-xs font-bold tracking-widest uppercase text-[#0071e3] mb-3">Cara Kerja</p>
            <h2 id="how-heading" class="font-bold tracking-[-0.025em] text-[#1d1d1f] mb-4"
                style="font-size: clamp(1.875rem, 4vw, 3rem);">
                Empat langkah,<br>satu solusi.
            </h2>
            <p class="text-[#6e6e73] max-w-md mx-auto font-light text-lg">
                Dari foto hingga perbaikan — proses yang cepat, transparan, dan aman.
            </p>
        </div>

        @php
            $steps = [
                ['num' => '01', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Unggah Foto', 'desc' => 'Foto perangkat yang bermasalah — dari berbagai sudut jika perlu.', 'color' => '#0071e3'],
                ['num' => '02', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jawab Pertanyaan', 'desc' => 'Sistem pakar akan bertanya lebih lanjut untuk mempersempit diagnosis.', 'color' => '#5856d6'],
                ['num' => '03', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'title' => 'Lihat Diagnosis', 'desc' => 'Dapatkan kemungkinan kerusakan beserta tingkat kecocokan dan alasan logisnya.', 'color' => '#34c759'],
                ['num' => '04', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'title' => 'Perbaiki atau Hubungi Teknisi', 'desc' => 'Ikuti panduan perbaikan mandiri, atau temukan teknisi terverifikasi terdekat.', 'color' => '#ff9500'],
            ];
        @endphp

        {{-- Steps desktop (horizontal) --}}
        <div class="hidden md:flex items-start gap-0 reveal">
            @foreach($steps as $idx => $step)
            <div class="flex-1 text-center reveal reveal-d{{ $idx + 1 }}">
                {{-- Number circle --}}
                <div class="relative mx-auto mb-6" style="width:80px;height:80px;">
                    <div class="absolute inset-0 rounded-full opacity-10" style="background:{{ $step['color'] }};"></div>
                    <div class="absolute inset-2 rounded-full flex items-center justify-center" style="background:{{ $step['color'] }};">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-[#1d1d1f] text-white text-[10px] font-bold flex items-center justify-center leading-none" aria-hidden="true">
                        {{ $idx + 1 }}
                    </span>
                </div>
                <h3 class="font-bold text-[#1d1d1f] text-base mb-2">{{ $step['title'] }}</h3>
                <p class="text-[#6e6e73] text-sm leading-relaxed max-w-[160px] mx-auto">{{ $step['desc'] }}</p>
            </div>
            @if(!$loop->last)
            <div class="flex-shrink-0 flex items-center" style="padding-top: 36px; padding-left: 4px; padding-right: 4px;">
                <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Steps mobile (vertical) --}}
        <div class="md:hidden space-y-6">
            @foreach($steps as $idx => $step)
            <div class="flex items-start gap-4 reveal reveal-d{{ $idx + 1 }}">
                <div class="relative flex-shrink-0" style="width:52px;height:52px;">
                    <div class="absolute inset-0 rounded-2xl opacity-10" style="background:{{ $step['color'] }};"></div>
                    <div class="absolute inset-1.5 rounded-xl flex items-center justify-center" style="background:{{ $step['color'] }};">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 pt-1">
                    <h3 class="font-bold text-[#1d1d1f] text-base mb-1">{{ $step['title'] }}</h3>
                    <p class="text-[#6e6e73] text-sm leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="text-center mt-14 reveal">
            <a href="{{ route('how-it-works') }}" class="link-arrow text-base">
                Pelajari selengkapnya <span aria-hidden="true">›</span>
            </a>
        </div>

    </div>
</section>
