<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FIXMATE') - Diagnose. Repair. Connect.</title>
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
                            'accent-hover': '#D4A63E',
                            dark: '#1A2332',
                            'dark-surface': '#212D3B',
                            text: '#1F2937',
                            muted: '#6B7280',
                            light: '#F5F6F3',
                        }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
        .ring-focus:focus { outline: none; box-shadow: 0 0 0 3px rgba(61,139,122,0.15); border-color: #3D8B7A; }
        .btn-primary { background: #3D8B7A; transition: all 0.2s ease; }
        .btn-primary:hover { background: #2A6356; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(61,139,122,0.25); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: #3D8B7A; transition: width 0.25s ease; border-radius: 2px; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); }
    </style>
    @stack('styles')
</head>
<body class="bg-fm-light text-fm-text">

@include('layouts.partials.nav')

<main class="min-h-screen">
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-3 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-3 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-3">{{ session('info') }}</div>
        </div>
    @endif

    @yield('content')
</main>

@include('layouts.partials.footer')
@stack('scripts')
</body>
</html>
