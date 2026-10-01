<nav
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 }, { passive: true })"
    :class="scrolled ? 'nav-blur shadow-sm' : 'bg-transparent'"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    aria-label="Navigasi utama"
    style="border-bottom: 1px solid transparent;"
    :style="scrolled ? 'border-bottom-color: rgba(0,0,0,.06)' : ''"
>
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
        <div class="flex items-center justify-between h-14">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight text-[#1d1d1f]" aria-label="FIXMATE beranda">
                FIXMATE
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden md:flex items-center gap-7">
                @foreach([['#fitur','Fitur'],['#etalase','Etalase'],['#cara-kerja','Cara Kerja'],['#teknisi','Teknisi']] as [$href, $label])
                <a href="{{ $href }}" class="text-sm text-[#6e6e73] hover:text-[#1d1d1f] transition-colors duration-200 font-medium">{{ $label }}</a>
                @endforeach
            </div>

            {{-- Desktop buttons --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm text-[#0071e3] hover:text-[#0077ed] font-medium transition-colors">
                    Masuk
                </a>
                @auth
                <a href="{{ route('diagnosis.create') }}" class="btn-pill btn-blue text-sm py-2 px-5">Mulai Diagnosis</a>
                @else
                <a href="{{ route('diagnosis.create') }}" class="btn-pill btn-blue text-sm py-2 px-5">Mulai Diagnosis</a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="open = !open"
                class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg text-[#1d1d1f] hover:bg-black/5 transition-colors"
                :aria-expanded="open.toString()"
                aria-label="Buka menu navigasi"
            >
                <svg x-show="!open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden nav-blur border-t border-black/[.06] px-5 py-4"
    >
        <div class="flex flex-col gap-0.5 mb-4">
            @foreach([['#fitur','Fitur'],['#etalase','Etalase'],['#cara-kerja','Cara Kerja'],['#teknisi','Teknisi']] as [$href, $label])
            <a href="{{ $href }}" @click="open=false" class="block py-2.5 text-sm text-[#1d1d1f] hover:text-[#0071e3] transition-colors font-medium">{{ $label }}</a>
            @endforeach
        </div>
        <div class="flex flex-col gap-2 pt-3 border-t border-black/[.06]">
            <a href="{{ route('login') }}" class="btn-pill btn-outline text-sm text-center">Masuk</a>
            <a href="{{ route('diagnosis.create') }}" class="btn-pill btn-blue text-sm text-center">Mulai Diagnosis</a>
        </div>
    </div>
</nav>
