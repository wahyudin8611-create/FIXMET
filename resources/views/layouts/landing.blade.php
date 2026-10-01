<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FIXMATE — Diagnose. Repair. Connect.')</title>
    <meta name="description" content="@yield('description', 'FIXMATE menggabungkan analisis visual AI dan sistem pakar untuk menemukan kemungkinan kerusakan perangkatmu, lalu memandu perbaikan atau menghubungkanmu dengan teknisi terverifikasi.')">
    <meta property="og:title" content="@yield('og_title', 'FIXMATE — Foto Masalahnya, Temukan Solusinya')">
    <meta property="og:description" content="@yield('og_description', 'Diagnosis kerusakan perangkat berbasis foto dan sistem pakar. Temukan panduan perbaikan atau hubungi teknisi terverifikasi.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        apple: { blue: '#0071e3', dark: '#1d1d1f', gray: '#f5f5f7', mid: '#6e6e73' }
                    },
                    fontFamily: { sans: ['-apple-system','Inter','system-ui','sans-serif'] }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html { scroll-behavior: smooth; }
        body { font-family: -apple-system, 'Inter', system-ui, sans-serif; color: #1d1d1f; background: #fff; overflow-x: hidden; }
        [x-cloak] { display: none !important; }

        /* Focus */
        :focus-visible { outline: 3px solid #0071e3; outline-offset: 3px; border-radius: 4px; }

        /* Section spacing */
        .l-section { padding: 96px 0; }
        @media (min-width: 1024px) { .l-section { padding: 128px 0; } }

        /* Scroll reveal */
        @media (prefers-reduced-motion: no-preference) {
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity 0.75s cubic-bezier(.25,.46,.45,.94), transform 0.75s cubic-bezier(.25,.46,.45,.94);
            }
            .reveal.revealed { opacity: 1; transform: translateY(0); }
            .reveal-d1 { transition-delay: .1s; }
            .reveal-d2 { transition-delay: .2s; }
            .reveal-d3 { transition-delay: .3s; }
            .reveal-d4 { transition-delay: .4s; }
        }

        /* Navbar */
        .nav-blur {
            background: rgba(255,255,255,0.84);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .nav-dark-blur {
            background: rgba(0,0,0,0.72);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }

        /* Buttons */
        .btn-pill { display: inline-flex; align-items: center; justify-content: center; padding: .625rem 1.5rem; border-radius: 9999px; font-weight: 500; font-size: .9375rem; transition: all .25s ease; cursor: pointer; white-space: nowrap; text-decoration: none; }
        .btn-blue { background: #0071e3; color: #fff; }
        .btn-blue:hover { background: #0077ed; box-shadow: 0 4px 16px rgba(0,113,227,.35); }
        .btn-outline { border: 1.5px solid rgba(0,113,227,.5); color: #0071e3; background: transparent; }
        .btn-outline:hover { background: rgba(0,113,227,.06); border-color: #0071e3; }
        .btn-white { background: #fff; color: #1d1d1f; }
        .btn-white:hover { background: #f0f0f0; }
        .btn-white-outline { border: 1.5px solid rgba(255,255,255,.3); color: #fff; background: transparent; }
        .btn-white-outline:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.6); }
        .link-arrow { color: #0071e3; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; font-size: .9375rem; text-decoration: none; }
        .link-arrow:hover { color: #0077ed; }
        .link-arrow-white { color: #fff; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; font-size: .9375rem; text-decoration: none; opacity: .9; }
        .link-arrow-white:hover { opacity: 1; }

        /* Hero gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #0071e3 0%, #5856d6 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* Bento cards */
        .bento-card { position: relative; overflow: hidden; border-radius: 24px; cursor: pointer; }
        .bento-card .bento-img { transition: transform .6s cubic-bezier(.25,.46,.45,.94); }
        .bento-card:hover .bento-img { transform: scale(1.07); }
        .bento-card .bento-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.15) 50%, transparent 100%); }
        .bento-card:hover .bento-link { color: #fff; opacity: 1; }

        /* Card hover */
        .card-lift { transition: transform .35s cubic-bezier(.25,.46,.45,.94), box-shadow .35s ease; }
        .card-lift:hover { transform: translateY(-4px); box-shadow: 0 24px 48px rgba(0,0,0,.12); }

        /* Stats number */
        .stat-num { font-size: 3.5rem; font-weight: 700; letter-spacing: -.04em; line-height: 1; color: #0071e3; }
        @media (min-width: 768px) { .stat-num { font-size: 4.5rem; } }

        /* Risk badges */
        .badge-low      { background: #d1fae5; color: #065f46; }
        .badge-medium   { background: #fef3c7; color: #92400e; }
        .badge-high     { background: #fee2e2; color: #991b1b; }
        .badge-critical { background: #1c1917; color: #fafaf9; border: 1px solid #44403c; }

        /* Horizontal snap scroll (mobile bento) */
        .snap-scroll { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; gap: 1rem; padding-bottom: 1rem; scrollbar-width: none; }
        .snap-scroll::-webkit-scrollbar { display: none; }
        .snap-scroll > * { scroll-snap-align: start; flex-shrink: 0; }

        /* Step connector */
        .step-line { flex: 1; height: 1px; background: linear-gradient(90deg, #0071e3 0%, rgba(0,113,227,.15) 100%); margin: 0 1rem; }

        /* Tech card verified dot */
        .verified-dot { width: 8px; height: 8px; border-radius: 50%; background: #34c759; border: 2px solid #fff; }

        /* Dark section text */
        .dark-section { background: #1d1d1f; color: #fff; }
        .dark-section p { color: rgba(255,255,255,.72); }

        /* Parallax target */
        .hero-mock { will-change: transform; }

        /* Feature section image areas */
        .feature-visual { border-radius: 20px; overflow: hidden; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')

    <script>
    (function() {
        // Scroll reveal
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

        // Count-up animation
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

        // Parallax hero mock
        var mock = document.querySelector('.hero-mock');
        if (mock && !prefersReduced) {
            window.addEventListener('scroll', function() {
                mock.style.transform = 'translateY(' + (window.scrollY * 0.18) + 'px)';
            }, { passive: true });
        }
    })();
    </script>
    @stack('scripts')
</body>
</html>
