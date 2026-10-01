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
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <style>
        * { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .ring-focus:focus { outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.15); border-color: #2563eb; }
        .btn-primary { background: linear-gradient(135deg, #2563eb, #7c3aed); transition: all 0.2s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #1d4ed8, #6d28d9); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(37,99,235,0.3); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, #2563eb, #7c3aed); transition: width 0.25s ease; border-radius: 2px; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">

@include('layouts.partials.nav')

<main class="min-h-screen">
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-3 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-3 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-3">{{ session('info') }}</div>
        </div>
    @endif

    @yield('content')
</main>

@include('layouts.partials.footer')
@stack('scripts')
</body>
</html>
