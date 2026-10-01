<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FIXMATE')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', sans-serif; }
        .ring-focus { transition: box-shadow 0.15s ease, border-color 0.15s ease; }
        .ring-focus:focus { outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.15); border-color: #2563eb; }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(37,99,235,0.35);
        }
        .btn-violet {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            transition: all 0.2s ease;
        }
        .btn-violet:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #9333ea 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(124,58,237,0.35);
        }
        .step-line { background: linear-gradient(90deg, #2563eb, #7c3aed); }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>
