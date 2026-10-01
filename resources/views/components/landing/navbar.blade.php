{{-- Top bar --}}
<div class="topbar-gradient text-white py-2.5 relative z-[60]" style="font-size:.75rem;letter-spacing:.01em;">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="flex gap-0.5">
                @for($i = 0; $i < 5; $i++)
                <svg class="w-3 h-3 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <span class="font-bold" style="font-variant-numeric:tabular-nums;">4.9</span>
            <span class="opacity-60 font-medium">(500+ ulasan pengguna)</span>
        </div>
        <div class="hidden sm:flex items-center gap-2.5">
            <span class="opacity-60 font-medium">Diagnosis perangkat tersedia 24/7</span>
            <span class="opacity-40">·</span>
            <a href="{{ route('register') }}" class="font-bold underline underline-offset-2 hover:opacity-80 transition-opacity">Mulai sekarang</a>
        </div>
    </div>
</div>

{{-- Main nav --}}
<nav
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 }, { passive: true })"
    :class="scrolled ? 'nav-blur shadow-sm' : 'bg-white'"
    class="sticky top-0 inset-x-0 z-50 transition-all duration-300"
    aria-label="Navigasi utama"
    style="border-bottom: 1px solid transparent;"
    :style="scrolled ? 'border-bottom-color: rgba(0,0,0,.06)' : 'border-bottom-color: rgba(0,0,0,.04)'"
>
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5" aria-label="FIXMET beranda">
                <div class="w-9 h-9 rounded-xl bg-fm-primary flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-fm-dark" style="font-size:1.25rem;letter-spacing:-.04em;">FIXMET</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden lg:flex items-center gap-8">
                @foreach([['#layanan','Layanan'],['#cara-kerja','Cara Kerja'],['#etalase','Perangkat'],['#teknisi','Teknisi'],['about','Tentang']] as [$href, $label])
                <a href="{{ str_starts_with($href, '#') ? $href : route($href) }}" class="text-fm-muted hover:text-fm-dark transition-colors duration-200 font-medium" style="font-size:.875rem;letter-spacing:-.005em;">{{ $label }}</a>
                @endforeach
            </div>

            {{-- Desktop buttons --}}
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-fm-dark hover:text-fm-primary font-semibold transition-colors" style="font-size:.875rem;letter-spacing:-.005em;">
                    Masuk
                </a>
                @auth
                <a href="{{ route('diagnosis.create') }}" class="btn-primary text-sm py-2.5 px-5">Mulai Diagnosis</a>
                @else
                <a href="{{ route('diagnosis.create') }}" class="btn-primary text-sm py-2.5 px-5">Mulai Diagnosis</a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="open = !open"
                class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl text-fm-dark hover:bg-fm-light transition-colors"
                :aria-expanded="open.toString()"
                aria-label="Buka menu navigasi"
            >
                <svg x-show="!open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden bg-white border-t border-black/[.06] px-5 py-5"
    >
        <div class="flex flex-col gap-1 mb-4">
            @foreach([['#layanan','Layanan'],['#cara-kerja','Cara Kerja'],['#etalase','Perangkat'],['#teknisi','Teknisi']] as [$href, $label])
            <a href="{{ $href }}" @click="open=false" class="block py-2.5 text-sm text-fm-dark hover:text-fm-primary transition-colors font-medium">{{ $label }}</a>
            @endforeach
        </div>
        <div class="flex flex-col gap-2.5 pt-4 border-t border-black/[.06]">
            <a href="{{ route('login') }}" class="btn-outline text-sm text-center">Masuk</a>
            <a href="{{ route('diagnosis.create') }}" class="btn-primary text-sm text-center">Mulai Diagnosis</a>
        </div>
    </div>
</nav>
