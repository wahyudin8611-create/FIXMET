@props(['stats'])

<section class="l-section bg-white" aria-labelledby="stats-heading">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        <div class="text-center mb-14 reveal">
            <p class="text-xs font-bold tracking-widest uppercase text-[#0071e3] mb-3">Platform</p>
            <h2 id="stats-heading" class="font-bold tracking-[-0.025em] text-[#1d1d1f]"
                style="font-size: clamp(1.875rem, 4vw, 3rem);">
                FIXMATE dalam angka.
            </h2>
            <p class="text-[#6e6e73] mt-3 text-sm">*Angka placeholder — akan diperbarui saat platform live.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px rounded-2xl overflow-hidden border border-gray-100 shadow-sm" role="list">
            @foreach($stats as $idx => $stat)
            <div class="reveal reveal-d{{ $idx + 1 }} bg-white px-6 py-10 text-center" role="listitem">
                <div class="stat-num" aria-label="{{ $stat['value'] }}{{ $stat['suffix'] }} {{ $stat['label'] }}">
                    <span data-count-up="{{ $stat['value'] }}" aria-hidden="true">0</span><span aria-hidden="true">{{ $stat['suffix'] }}</span>
                </div>
                <p class="text-[#6e6e73] text-sm mt-2 font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>
