<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - FIXMET</title>
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
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    <aside class="w-64 bg-fm-dark text-white flex flex-col shrink-0">
        <div class="p-4 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-fm-primary rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="font-bold">FIXMET Admin</span>
            </a>
        </div>
        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-fm-primary/20 text-white' : 'text-gray-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                Dashboard
            </a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Pengguna</div>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-fm-primary/20 text-white' : '' }}">👥 Users</a>
            <a href="{{ route('admin.technicians.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10 {{ request()->routeIs('admin.technicians.*') ? 'bg-fm-primary/20 text-white' : '' }}">🔧 Teknisi</a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Knowledge Base</div>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">📂 Kategori</a>
            <a href="{{ route('admin.devices.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">📱 Perangkat</a>
            <a href="{{ route('admin.symptoms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">🩺 Gejala</a>
            <a href="{{ route('admin.diagnoses.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">🔍 Diagnosis</a>
            <a href="{{ route('admin.rules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">⚙️ Rules</a>
            <a href="{{ route('admin.solutions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">💡 Solusi</a>
            <a href="{{ route('admin.repair-guides.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">📖 Repair Guide</a>
            <div class="pt-2 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase">Aktivitas</div>
            <a href="{{ route('admin.consultations.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-white/10">💬 Konsultasi</a>
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
    <div class="flex-1 overflow-y-auto">
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-lg font-semibold text-fm-dark">@yield('page-title', 'Dashboard')</h1>
        </header>

        <main class="p-6">
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
</body>
</html>
