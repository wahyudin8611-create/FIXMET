<nav class="sticky top-0 z-50 border-b transition-all duration-300"
     style="background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); border-color: rgba(0,0,0,0.06);"
     x-data="{ mobileOpen: false, userOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :style="scrolled ? 'box-shadow: 0 1px 20px rgba(0,0,0,0.08)' : ''">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group flex-shrink-0">
                <div class="w-9 h-9 rounded-xl bg-fm-primary flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-lg tracking-tight text-fm-dark">FIXMET</span>
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

                    <div class="relative" @click.away="userOpen = false">
                        <button @click="userOpen = !userOpen"
                                class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-fm-light transition-colors group">
                            <div class="relative">
                                <img src="{{ auth()->user()->profile_photo_url }}"
                                     class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-100 group-hover:ring-fm-primary/30 transition-all"
                                     alt="{{ auth()->user()->name }}">
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white
                                     @if(auth()->user()->isAdmin()) bg-red-500
                                     @elseif(auth()->user()->isTechnician()) bg-emerald-500
                                     @else bg-fm-primary @endif">
                                </div>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-xs font-bold text-fm-dark leading-none">{{ Str::words(auth()->user()->name, 1, '') }}</p>
                                <p class="text-xs text-fm-muted capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <svg class="w-3.5 h-3.5 text-fm-muted transition-transform duration-200 hidden md:block"
                                 :class="userOpen ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="userOpen" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                             style="box-shadow: 0 10px 40px rgba(0,0,0,0.12);">

                            <div class="px-4 py-3.5 border-b border-gray-50">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ auth()->user()->profile_photo_url }}"
                                         class="w-9 h-9 rounded-xl object-cover" alt="">
                                    <div>
                                        <p class="text-sm font-bold text-fm-dark">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-fm-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full capitalize
                                         @if(auth()->user()->isAdmin()) bg-red-100 text-red-700
                                         @elseif(auth()->user()->isTechnician()) bg-emerald-100 text-emerald-700
                                         @else bg-fm-primary/10 text-fm-primary @endif">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>

                            <div class="py-1.5">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                                        </div>
                                        Dashboard Admin
                                    </a>
                                @elseif(auth()->user()->isTechnician())
                                    <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                                        </div>
                                        Dashboard Teknisi
                                    </a>
                                @else
                                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-fm-primary/10 flex items-center justify-center group-hover:bg-fm-primary/20 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                                        </div>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('diagnosis.create') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-fm-accent/10 flex items-center justify-center group-hover:bg-fm-accent/20 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-fm-accent-hover" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                                        </div>
                                        Mulai Diagnosa
                                    </a>
                                    <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-fm-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        Edit Profil
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-50 py-1.5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        </div>
                                        Keluar dari Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
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
            @if(auth()->user()->isUser())
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-fm-text hover:bg-fm-light">Dashboard Saya</a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
            </form>
        </div>
        @endguest
    </div>
</nav>
