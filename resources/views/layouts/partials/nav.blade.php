<nav class="sticky top-0 z-50 border-b transition-all duration-300"
     style="background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); border-color: rgba(0,0,0,0.06);"
     x-data="{ mobileOpen: false, userOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :style="scrolled ? 'box-shadow: 0 1px 20px rgba(0,0,0,0.08)' : ''">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ── Logo ── --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group flex-shrink-0">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200"
                     style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-lg tracking-tight"
                      style="background: linear-gradient(135deg, #1d4ed8, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    FIXMATE
                </span>
            </a>

            {{-- ── Desktop nav links ── --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('home') ? 'text-blue-700 active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('how-it-works') }}" class="nav-link px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('how-it-works') ? 'text-blue-700 active' : '' }}">
                    Cara Kerja
                </a>
                <a href="{{ route('technicians.index') }}" class="nav-link px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('technicians.*') ? 'text-blue-700 active' : '' }}">
                    Teknisi
                </a>
                <a href="{{ route('about') }}" class="nav-link px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('about') ? 'text-blue-700 active' : '' }}">
                    Tentang
                </a>
            </div>

            {{-- ── Right side ── --}}
            <div class="flex items-center gap-2 md:gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-bold text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Daftar Gratis
                    </a>
                @else
                    {{-- Quick action button --}}
                    @if(auth()->user()->isUser())
                    <a href="{{ route('user.diagnosis.create') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-bold text-white px-3.5 py-2 rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Diagnosa
                    </a>
                    @endif

                    {{-- User dropdown --}}
                    <div class="relative" @click.away="userOpen = false">
                        <button @click="userOpen = !userOpen"
                                class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="relative">
                                <img src="{{ auth()->user()->profile_photo_url }}"
                                     class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-100 group-hover:ring-blue-200 transition-all"
                                     alt="{{ auth()->user()->name }}">
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white
                                     @if(auth()->user()->isAdmin()) bg-red-500
                                     @elseif(auth()->user()->isTechnician()) bg-emerald-500
                                     @else bg-blue-500 @endif">
                                </div>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-xs font-bold text-gray-900 leading-none">{{ Str::words(auth()->user()->name, 1, '') }}</p>
                                <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200 hidden md:block"
                                 :class="userOpen ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="userOpen" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                             style="box-shadow: 0 10px 40px rgba(0,0,0,0.12);">

                            {{-- User info header --}}
                            <div class="px-4 py-3.5 border-b border-gray-50">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ auth()->user()->profile_photo_url }}"
                                         class="w-9 h-9 rounded-xl object-cover" alt="">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full capitalize
                                         @if(auth()->user()->isAdmin()) bg-red-100 text-red-700
                                         @elseif(auth()->user()->isTechnician()) bg-emerald-100 text-emerald-700
                                         @else bg-blue-100 text-blue-700 @endif">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>

                            <div class="py-1.5">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                            </svg>
                                        </div>
                                        Dashboard Admin
                                    </a>
                                @elseif(auth()->user()->isTechnician())
                                    <a href="{{ route('technician.dashboard') }}"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                            </svg>
                                        </div>
                                        Dashboard Teknisi
                                    </a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                            </svg>
                                        </div>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('user.diagnosis.create') }}"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-violet-50 flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                                            </svg>
                                        </div>
                                        Mulai Diagnosa
                                    </a>
                                    <a href="{{ route('user.profile.edit') }}"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        Edit Profil
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-50 py-1.5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </div>
                                        Keluar dari Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                {{-- Mobile menu button --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Mobile menu ── --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : '' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
        <a href="{{ route('how-it-works') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Cara Kerja
        </a>
        <a href="{{ route('technicians.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Teknisi
        </a>
        <a href="{{ route('about') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Tentang
        </a>

        @guest
        <div class="pt-2 border-t border-gray-100 grid grid-cols-2 gap-2">
            <a href="{{ route('login') }}" class="text-center py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="text-center py-2.5 text-sm font-bold text-white rounded-xl"
               style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                Daftar Gratis
            </a>
        </div>
        @else
        <div class="pt-2 border-t border-gray-100 space-y-1">
            @if(auth()->user()->isUser())
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                Dashboard Saya
            </a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
        @endguest
    </div>
</nav>
