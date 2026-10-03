{{--
    FIXMATE logo mark ("Perisai Detak"): shield with a pulse line.
    Usage: <x-logo-mark class="w-9 h-9" />
--}}
@php($gradientId = 'fixmate-logo-'.\Illuminate\Support\Str::random(8))

<svg {{ $attributes->merge(['class' => 'shrink-0 rounded-[25%]']) }} viewBox="0 0 64 64" role="img" aria-label="FIXMATE">
    <defs>
        <linearGradient id="{{ $gradientId }}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#47A08C" />
            <stop offset="1" stop-color="#2A6356" />
        </linearGradient>
    </defs>
    <rect width="64" height="64" rx="16" fill="url(#{{ $gradientId }})" />
    <path d="M32 11.5l15 5.5v12.5c0 9.6-6.3 17.4-15 21.5-8.7-4.1-15-11.9-15-21.5V17z" fill="none" stroke="#fff" stroke-width="4.2" stroke-linejoin="round" />
    <path d="M21.5 31h5.5l3-6.5 4.5 13 3-6.5h5" fill="none" stroke="#E2B85B" stroke-width="3.8" stroke-linecap="round" stroke-linejoin="round" />
</svg>
