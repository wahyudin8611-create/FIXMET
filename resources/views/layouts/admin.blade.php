<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('images/logo/fixmate-icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/apple-touch-icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - FIXMATE</title>
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
<body class="bg-gray-100" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
<div class="flex h-screen overflow-hidden">
    {{-- Sidebar: slides in over the page on phones, always visible from lg --}}
    <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>

    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-fm-dark text-white flex flex-col shrink-0 transition-transform duration-200 -translate-x-full lg:static lg:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
        <div class="p-4 border-b border-white/10 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-logo-mark class="w-7 h-7" />
                <span class="font-bold">FIX<span class="text-fm-primary-light">MATE</span> Admin</span>
            </a>
            <button type="button" @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-gray-300 hover:bg-white/10" aria-label="Tutup menu">
                <x-icon name="x" class="w-5 h-5" />
            </button>
        </div>
        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-fm-primary/20 text-white' : 'text-gray-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                Dashboard
            </a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Pengguna</div>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-fm-primary/20 text-white' : '' }}"><x-icon name="users" class="w-4 h-4 shrink-0" /> Users</a>
            <a href="{{ route('admin.technicians.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 {{ request()->routeIs('admin.technicians.*') ? 'bg-fm-primary/20 text-white' : '' }}"><x-icon name="wrench" class="w-4 h-4 shrink-0" /> Teknisi</a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Knowledge Base</div>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="folder" class="w-4 h-4 shrink-0" /> Kategori</a>
            <a href="{{ route('admin.devices.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="device-mobile" class="w-4 h-4 shrink-0" /> Perangkat</a>
            <a href="{{ route('admin.symptoms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="clipboard-check" class="w-4 h-4 shrink-0" /> Gejala</a>
            <a href="{{ route('admin.diagnoses.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="search" class="w-4 h-4 shrink-0" /> Diagnosis</a>
            <a href="{{ route('admin.rules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="cog" class="w-4 h-4 shrink-0" /> Rules</a>
            <a href="{{ route('admin.solutions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="light-bulb" class="w-4 h-4 shrink-0" /> Solusi</a>
            <a href="{{ route('admin.repair-guides.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="book-open" class="w-4 h-4 shrink-0" /> Repair Guide</a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Aktivitas</div>
            <a href="{{ route('admin.consultations.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10"><x-icon name="chat" class="w-4 h-4 shrink-0" /> Konsultasi</a>
        </nav>
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-2 text-sm">
                <img src="{{ auth()->user()->profile_photo_url }}" class="w-7 h-7 rounded-full" alt="">
                <span class="text-gray-300 truncate">{{ auth()->user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-300">Keluar</button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 min-w-0 overflow-y-auto">
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-4 flex items-center gap-3">
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
@stack('scripts')
</body>
</html>
