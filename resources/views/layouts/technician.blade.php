<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teknisi') - FIXMET</title>
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
<body class="bg-gray-50">
<div class="flex h-screen overflow-hidden">
    <aside class="w-60 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b">
            <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-fm-primary rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="font-bold text-fm-primary">FIXMET</span>
            </a>
        </div>
        <nav class="flex-1 py-4 px-3 space-y-1 text-sm">
            <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('technician.dashboard') ? 'bg-fm-primary/10 text-fm-primary font-medium' : 'text-gray-700' }}"><x-icon name="home" class="w-4 h-4 shrink-0" /> Dashboard</a>
            <a href="{{ route('technician.requests') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700"><x-icon name="inbox" class="w-4 h-4 shrink-0" /> Permintaan Baru</a>
            <a href="{{ route('technician.bookings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700"><x-icon name="clipboard-list" class="w-4 h-4 shrink-0" /> Booking</a>
            <a href="{{ route('technician.messages.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700"><x-icon name="chat" class="w-4 h-4 shrink-0" /> Pesan</a>
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

    <div class="flex-1 overflow-y-auto">
        <header class="bg-white border-b px-6 py-4">
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
