<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('images/logo/fixmate-icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/apple-touch-icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teknisi') - FIXMATE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef7f5', 100: '#d5ede8', 200: '#aedbd2', 300: '#7ec4b7',
                            400: '#5BA897', 500: '#3D8B7A', 600: '#3D8B7A', 700: '#2A6356',
                            800: '#1e4a3f', 900: '#153530',
                        },
                        fm: {
                            primary: '#3D8B7A',
                            'primary-light': '#5BA897',
                            'primary-dark': '#2A6356',
                            accent: '#E2B85B',
                            dark: '#1A2332',
                            'dark-surface': '#212D3B',
                            light: '#F5F6F3',
                            muted: '#6B7280',
                        }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
<div class="flex h-screen overflow-hidden">
    {{-- On phones the sidebar slides in over the page; from lg it is always visible --}}
    <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    <aside class="fixed inset-y-0 left-0 z-40 w-60 bg-white border-r border-gray-200 flex flex-col transition-transform duration-200 -translate-x-full lg:static lg:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
        <div class="p-4 border-b flex items-center justify-between">
            <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-2">
                <x-logo-mark class="w-7 h-7" />
                <span class="font-bold text-fm-dark">FIX<span class="text-fm-primary">MATE</span></span>
            </a>
            <button type="button" @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup menu">
                <x-icon name="x" class="w-5 h-5" />
            </button>
        </div>
        <nav class="flex-1 py-4 px-3 space-y-1 text-sm">
            <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('technician.dashboard') ? 'bg-fm-primary/10 text-fm-primary font-medium' : 'text-gray-700' }}"><x-icon name="home" class="w-4 h-4 shrink-0" /> Dashboard</a>
            <a href="{{ route('technician.requests') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('technician.requests') ? 'bg-fm-primary/10 text-fm-primary font-medium' : 'text-gray-700' }}">
                <x-icon name="inbox" class="w-4 h-4 shrink-0" /> Permintaan Baru
                <span id="navRequests" class="hidden ml-auto min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[11px] font-bold leading-none items-center justify-center">0</span>
            </a>
            <a href="{{ route('technician.bookings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700"><x-icon name="clipboard-list" class="w-4 h-4 shrink-0" /> Booking</a>
            <a href="{{ route('technician.messages.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('technician.messages.*') ? 'bg-fm-primary/10 text-fm-primary font-medium' : 'text-gray-700' }}">
                <x-icon name="chat" class="w-4 h-4 shrink-0" /> Pesan
                <span id="navUnread" class="hidden ml-auto min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[11px] font-bold leading-none items-center justify-center">0</span>
            </a>
            <a href="{{ route('technician.profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700"><x-icon name="user" class="w-4 h-4 shrink-0" /> Profil</a>
        </nav>
        <div class="p-4 border-t">
            <div class="flex items-center gap-2 text-sm mb-2">
                <img src="{{ auth()->user()->profile_photo_url }}" class="w-7 h-7 rounded-full" alt="">
                <span class="text-gray-700 truncate">{{ auth()->user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-red-500 hover:text-red-700">Keluar</button>
            </form>
        </div>
    </aside>

    <div class="flex-1 min-w-0 overflow-y-auto">
        <header class="bg-white border-b px-4 sm:px-6 py-4 flex items-center gap-3">
            <button type="button" @click="sidebarOpen = true" class="lg:hidden -ml-1 p-1.5 rounded-lg text-gray-600 hover:bg-gray-100" aria-label="Buka menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-lg font-semibold text-fm-dark">@yield('page-title', 'Dashboard')</h1>
        </header>
        <main class="p-4 sm:p-6">
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-3 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-xl p-3 text-sm">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@auth
    @include('partials.echo')
    @include('partials.notifications')
@endauth
@stack('scripts')
</body>
</html>
