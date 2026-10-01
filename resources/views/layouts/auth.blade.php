<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FIXMET')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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
        .ring-focus { transition: box-shadow 0.15s ease, border-color 0.15s ease; }
        .ring-focus:focus { outline: none; box-shadow: 0 0 0 3px rgba(61,139,122,0.15); border-color: #3D8B7A; }
        .btn-primary { background: #3D8B7A; transition: all 0.2s ease; }
        .btn-primary:hover { background: #2A6356; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(61,139,122,0.3); }
        .btn-accent { background: #E2B85B; color: #1A2332; transition: all 0.2s ease; }
        .btn-accent:hover { background: #D4A63E; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(226,184,91,0.3); }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-fm-light antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>
