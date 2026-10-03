@props(['stats'])

<section class="l-section" style="background:#F5F6F3;" aria-labelledby="stats-heading">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">

        <div class="text-center mb-14 reveal">
            <p class="eyebrow text-fm-primary mb-4">Platform</p>
            <h2 id="stats-heading" class="display-lg text-fm-dark"
                style="font-size: clamp(1.875rem, 4vw, 3rem);">
                FIXMATE dalam angka
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6" role="list">
            @foreach($stats as $idx => $stat)
            <div class="reveal reveal-d{{ $idx + 1 }} bg-white rounded-2xl px-6 py-10 text-center shadow-sm border border-black/[.04]" role="listitem">
                <div class="stat-num" aria-label="{{ $stat['value'] }}{{ $stat['suffix'] }} {{ $stat['label'] }}">
                    <span data-count-up="{{ $stat['value'] }}" aria-hidden="true">0</span><span aria-hidden="true">{{ $stat['suffix'] }}</span>
                </div>
                <p class="text-fm-muted mt-3 font-medium" style="font-size:.875rem;letter-spacing:-.005em;">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>
