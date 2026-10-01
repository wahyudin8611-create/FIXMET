<section id="cara-kerja" class="l-section bg-white" aria-labelledby="how-heading">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Left: Heading + CTA --}}
            <div class="reveal">
                <p class="eyebrow text-fm-primary mb-5">Cara Kerja</p>
                <h2 id="how-heading" class="display-lg text-fm-dark mb-5"
                    style="font-size: clamp(2rem, 4.5vw, 3rem);">
                    Perangkatmu dilindungi dari awal hingga selesai
                </h2>
                <p class="body-lg max-w-md mb-8">
                    Dari foto kerusakan hingga perbaikan tuntas — proses yang cepat, transparan, dan aman.
                </p>
                @auth
                <a href="{{ route('diagnosis.create') }}" class="btn-primary text-base px-8 py-3.5">Mulai Diagnosis</a>
                @else
                <a href="{{ route('diagnosis.create') }}" class="btn-primary text-base px-8 py-3.5">Mulai Diagnosis</a>
                @endauth
            </div>

            {{-- Right: Numbered steps (Maverick style) --}}
            <div class="space-y-0">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Ceritakan masalahnya', 'desc' => 'Unggah foto perangkat yang bermasalah dan ceritakan gejalanya. Sistem kami mulai menganalisis dari sini.'],
                        ['num' => '02', 'title' => 'Kami diagnosis & analisis', 'desc' => 'Sistem pakar mencocokkan gejala dengan database kerusakan. Jawab pertanyaan lanjutan untuk diagnosis lebih akurat.'],
                        ['num' => '03', 'title' => 'Dapatkan solusi', 'desc' => 'Lihat hasil diagnosis lengkap dengan confidence score, panduan perbaikan bertingkat, dan label risiko.'],
                        ['num' => '04', 'title' => 'Perbaiki atau panggil teknisi', 'desc' => 'Ikuti panduan perbaikan mandiri, atau temukan dan booking teknisi terverifikasi terdekat.'],
                    ];
                @endphp

                @foreach($steps as $idx => $step)
                <div class="reveal reveal-d{{ $idx + 1 }} flex gap-5 {{ !$loop->last ? 'pb-8' : '' }} relative">
                    {{-- Vertical line connector --}}
                    @if(!$loop->last)
                    <div class="absolute left-[19px] top-[48px] bottom-0 w-px bg-gradient-to-b from-fm-primary/30 to-transparent" aria-hidden="true"></div>
                    @endif

                    {{-- Number circle --}}
                    <div class="step-number flex-shrink-0 mt-1">{{ $step['num'] }}</div>

                    {{-- Content --}}
                    <div class="flex-1 pt-0.5">
                        <h3 class="font-bold text-fm-dark mb-1.5" style="font-size:1.0625rem;letter-spacing:-.02em;">{{ $step['title'] }}</h3>
                        <p class="body-sm">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
