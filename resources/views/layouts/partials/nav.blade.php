<nav class="sticky top-0 z-50 border-b transition-all duration-300"
     style="background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); border-color: rgba(0,0,0,0.06);"
     x-data="{ mobileOpen: false, userOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-[0_1px_20px_rgba(0,0,0,0.08)]' : ''">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group flex-shrink-0">
                <x-logo-mark class="w-9 h-9 shadow-md group-hover:scale-105 transition-transform duration-200" />
                <span class="font-extrabold text-lg tracking-tight text-fm-dark">FIX<span class="text-fm-primary">MATE</span></span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link px-3 py-2 text-sm font-medium text-fm-muted hover:text-fm-dark rounded-lg hover:bg-fm-light transition-colors {{ request()->routeIs('home') ? 'text-fm-primary active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('how-it-works') }}" class="nav-link px-3 py-2 text-sm font-medium text-fm-muted hover:text-fm-dark rounded-lg hover:bg-fm-light transition-colors {{ request()->routeIs('how-it-works') ? 'text-fm-primary active' : '' }}">
                    Cara Kerja
                </a>
                <a href="{{ route('technicians.index') }}" class="nav-link px-3 py-2 text-sm font-medium text-fm-muted hover:text-fm-dark rounded-lg hover:bg-fm-light transition-colors {{ request()->routeIs('technicians.*') ? 'text-fm-primary active' : '' }}">
                    Teknisi
                </a>
                <a href="{{ route('about') }}" class="nav-link px-3 py-2 text-sm font-medium text-fm-muted hover:text-fm-dark rounded-lg hover:bg-fm-light transition-colors {{ request()->routeIs('about') ? 'text-fm-primary active' : '' }}">
                    Tentang
                </a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2 md:gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center text-sm font-semibold text-fm-muted hover:text-fm-dark px-3 py-2 rounded-lg hover:bg-fm-light transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-bold text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 bg-fm-primary hover:bg-fm-primary-dark">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Daftar Gratis
                    </a>
                @else
                    @if(auth()->user()->isUser())
                    <a href="{{ route('diagnosis.create') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-bold text-white px-3.5 py-2 rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 bg-fm-primary hover:bg-fm-primary-dark">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Diagnosa
                    </a>
                    @endif

                    @include('layouts.partials.dashboard-button', ['class' => 'hidden lg:inline-flex'])
                    @include('layouts.partials.user-menu')
                @endguest

                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-xl text-fm-muted hover:bg-fm-light transition-colors">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
        @foreach([['home','Beranda'],['how-it-works','Cara Kerja'],['technicians.index','Teknisi'],['about','Tentang']] as [$route, $label])
        <a href="{{ route($route) }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-fm-text hover:bg-fm-light {{ request()->routeIs($route) ? 'bg-fm-primary/5 text-fm-primary' : '' }}">{{ $label }}</a>
        @endforeach

        @guest
        <div class="pt-2 border-t border-gray-100 grid grid-cols-2 gap-2">
            <a href="{{ route('login') }}" class="text-center py-2.5 text-sm font-semibold text-fm-text bg-fm-light rounded-xl hover:bg-gray-200 transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="text-center py-2.5 text-sm font-bold text-white rounded-xl bg-fm-primary hover:bg-fm-primary-dark transition-colors">Daftar Gratis</a>
        </div>
        @else
        <div class="pt-2 border-t border-gray-100 space-y-1">
            <a href="{{ auth()->user()->dashboardUrl() }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-fm-primary hover:bg-fm-light">
                <x-icon name="home" class="w-4 h-4" /> Dashboard
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
            </form>
        </div>
        @endguest
    </div>
</nav>
