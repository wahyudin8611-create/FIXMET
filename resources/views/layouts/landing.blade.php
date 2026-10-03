<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FIXMATE — Diagnose. Repair. Connect.')</title>
    <meta name="description" content="@yield('description', 'FIXMATE menggabungkan analisis visual dan sistem pakar untuk menemukan kemungkinan kerusakan perangkatmu, lalu memandu perbaikan atau menghubungkanmu dengan teknisi terverifikasi.')">
    <meta property="og:title" content="@yield('og_title', 'FIXMATE — Foto Masalahnya, Temukan Solusinya')">
    <meta property="og:description" content="@yield('og_description', 'Diagnosis kerusakan perangkat berbasis foto dan sistem pakar.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                            'dark-card': '#253341',
                            text: '#1F2937',
                            muted: '#6B7280',
                            light: '#F5F6F3',
                            cream: '#FAFBF8',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: #1F2937; background: #fff; overflow-x: hidden; line-height: 1.6; letter-spacing: -.01em; }
        [x-cloak] { display: none !important; }

        h1, h2, h3, h4, h5, h6 { text-wrap: balance; }
        p { text-wrap: pretty; }

        :focus-visible { outline: 3px solid #3D8B7A; outline-offset: 3px; border-radius: 4px; }

        .l-section { padding: 80px 0; }
        @media (min-width: 1024px) { .l-section { padding: 112px 0; } }

        @media (prefers-reduced-motion: no-preference) {
            .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s cubic-bezier(.25,.46,.45,.94), transform .7s cubic-bezier(.25,.46,.45,.94); }
            .reveal.revealed { opacity: 1; transform: translateY(0); }
            .reveal-d1 { transition-delay: .1s; }
            .reveal-d2 { transition-delay: .2s; }
            .reveal-d3 { transition-delay: .3s; }
            .reveal-d4 { transition-delay: .4s; }
        }

        .nav-blur { background: rgba(255,255,255,0.88); backdrop-filter: saturate(180%) blur(20px); -webkit-backdrop-filter: saturate(180%) blur(20px); }

        .eyebrow { font-size: .6875rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; line-height: 1; }

        .display-xl { font-weight: 800; letter-spacing: -.035em; line-height: 1.06; }
        .display-lg { font-weight: 800; letter-spacing: -.03em; line-height: 1.1; }
        .display-md { font-weight: 800; letter-spacing: -.025em; line-height: 1.15; }

        .body-lg { font-size: 1.125rem; line-height: 1.75; color: #6B7280; }
        .body-md { font-size: 1rem; line-height: 1.7; color: #6B7280; }
        .body-sm { font-size: .875rem; line-height: 1.7; color: #6B7280; }

        .btn-primary { display: inline-flex; align-items: center; justify-content: center; padding: .75rem 1.75rem; border-radius: 12px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; background: #3D8B7A; color: #fff; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-primary:hover { background: #2A6356; box-shadow: 0 4px 16px rgba(61,139,122,.3); }
        .btn-accent { display: inline-flex; align-items: center; justify-content: center; padding: .75rem 1.75rem; border-radius: 12px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; background: #E2B85B; color: #1A2332; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-accent:hover { background: #D4A63E; box-shadow: 0 4px 16px rgba(226,184,91,.3); }
        .btn-outline-light { display: inline-flex; align-items: center; justify-content: center; padding: .7rem 1.75rem; border-radius: 12px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; border: 2px solid rgba(255,255,255,.3); color: #fff; background: transparent; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-outline-light:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.6); }
        .btn-outline { display: inline-flex; align-items: center; justify-content: center; padding: .7rem 1.75rem; border-radius: 12px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; border: 2px solid #3D8B7A; color: #3D8B7A; background: transparent; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-outline:hover { background: rgba(61,139,122,.06); }
        .btn-white { display: inline-flex; align-items: center; justify-content: center; padding: .75rem 1.75rem; border-radius: 12px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; background: #fff; color: #1A2332; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-white:hover { background: #f0f0f0; }

        .link-arrow { color: #3D8B7A; display: inline-flex; align-items: center; gap: 6px; font-weight: 650; font-size: .9375rem; letter-spacing: -.01em; text-decoration: none; transition: gap .2s ease, color .2s ease; }
        .link-arrow:hover { color: #2A6356; gap: 10px; }

        .card-lift { transition: transform .35s cubic-bezier(.25,.46,.45,.94), box-shadow .35s ease; }
        .card-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.08); }

        .stat-num { font-size: 3rem; font-weight: 800; letter-spacing: -.05em; line-height: 1; color: #3D8B7A; font-variant-numeric: tabular-nums; }
        @media (min-width: 768px) { .stat-num { font-size: 4rem; } }

        .badge-low { background: #d1fae5; color: #065f46; }
        .badge-medium { background: #fef3c7; color: #92400e; }
        .badge-high { background: #fee2e2; color: #991b1b; }
        .badge-critical { background: #1c1917; color: #fafaf9; border: 1px solid #44403c; }

        .snap-scroll { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; gap: 1rem; padding-bottom: 1rem; scrollbar-width: none; }
        .snap-scroll::-webkit-scrollbar { display: none; }
        .snap-scroll > * { scroll-snap-align: start; flex-shrink: 0; }

        .hero-gradient { background: linear-gradient(135deg, #1A2332 0%, #253341 40%, #1A2332 100%); }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(26,35,50,.95) 0%, rgba(26,35,50,.7) 50%, rgba(26,35,50,.4) 100%); }

        .feature-icon-box { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        .step-number { width: 42px; height: 42px; border-radius: 50%; background: #3D8B7A; color: #fff; font-weight: 800; font-size: .8125rem; letter-spacing: -.02em; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        .review-card { background: #fff; border-radius: 20px; padding: 28px; border: 1px solid rgba(0,0,0,.05); }
        .review-stars { color: #E2B85B; }

        .bento-card { position: relative; overflow: hidden; border-radius: 20px; cursor: pointer; }
        .bento-card .bento-img { transition: transform .6s cubic-bezier(.25,.46,.45,.94); }
        .bento-card:hover .bento-img { transform: scale(1.05); }

        .dark-section { background: #1A2332; color: #fff; }

        .topbar-gradient { background: linear-gradient(90deg, #3D8B7A 0%, #2A6356 100%); }

        .verified-dot { width: 8px; height: 8px; border-radius: 50%; background: #34c759; border: 2px solid #fff; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')

    <script>
    (function() {
        var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) {
            document.querySelectorAll('.reveal').forEach(function(el) { el.classList.add('revealed'); });
        } else {
            var revealObs = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) { entry.target.classList.add('revealed'); revealObs.unobserve(entry.target); }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
            document.querySelectorAll('.reveal').forEach(function(el) { revealObs.observe(el); });
        }

        function countUp(el) {
            var target = parseInt(el.dataset.countUp);
            if (isNaN(target)) return;
            if (prefersReduced) { el.textContent = target.toLocaleString('id-ID'); return; }
            var duration = 2000, start = performance.now();
            function animate(now) {
                var p = Math.min((now - start) / duration, 1);
                var e = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.floor(e * target).toLocaleString('id-ID');
                if (p < 1) requestAnimationFrame(animate);
                else el.textContent = target.toLocaleString('id-ID');
            }
            requestAnimationFrame(animate);
        }
        var countObs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = '1';
                    countUp(entry.target);
                }
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('[data-count-up]').forEach(function(el) { countObs.observe(el); });
    })();
    </script>
    @stack('scripts')
</body>
</html>
