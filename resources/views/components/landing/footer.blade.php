<footer style="background:#F5F6F3; border-top: 1px solid rgba(0,0,0,.06);" role="contentinfo">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16">

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-4 lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-fm-primary flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-fm-dark" style="font-size:1.125rem;letter-spacing:-.04em;">FIXMATE</span>
                </a>
                <p class="max-w-xs mb-6" style="font-size:.875rem;line-height:1.75;color:#6B7280;">
                    Platform diagnosis kerusakan perangkat berbasis foto dan sistem pakar.
                    Diagnose. Repair. Connect.
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('diagnosis.create') }}" class="btn-primary text-sm py-2 px-5">Mulai Diagnosis</a>
                    <a href="{{ route('login') }}" class="btn-outline text-sm py-2 px-5">Masuk</a>
                </div>
            </div>

            {{-- Platform --}}
            <div>
                <p class="eyebrow text-fm-dark mb-5">Platform</p>
                <ul class="space-y-3" role="list">
                    @foreach([['home','Beranda'],['about','Tentang'],['how-it-works','Cara Kerja'],['technicians.index','Teknisi']] as [$route, $label])
                    <li><a href="{{ route($route) }}" class="text-fm-muted hover:text-fm-primary transition-colors" style="font-size:.875rem;">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <p class="eyebrow text-fm-dark mb-5">Akun</p>
                <ul class="space-y-3" role="list">
                    @foreach([['login','Masuk'],['register','Daftar Pengguna'],['register.technician','Daftar Teknisi']] as [$route, $label])
                    <li><a href="{{ route($route) }}" class="text-fm-muted hover:text-fm-primary transition-colors" style="font-size:.875rem;">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <p class="eyebrow text-fm-dark mb-5">Legal</p>
                <ul class="space-y-3" role="list">
                    <li><span class="text-fm-muted" style="font-size:.875rem;">Kebijakan Privasi</span></li>
                    <li><span class="text-fm-muted" style="font-size:.875rem;">Syarat Penggunaan</span></li>
                </ul>
            </div>

        </div>

        <div style="height:1px;background:rgba(0,0,0,.08);margin-bottom:24px;" aria-hidden="true"></div>

        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <p class="text-fm-muted" style="font-size:.8125rem;">
                &copy; {{ date('Y') }} FIXMATE. Hak cipta dilindungi undang-undang.
            </p>
            <p class="text-fm-muted max-w-md sm:text-right" style="font-size:.8125rem;line-height:1.65;">
                <strong class="font-semibold">Disclaimer:</strong> Hasil diagnosis adalah kemungkinan berdasarkan foto dan gejala yang dilaporkan, bukan kepastian teknis. Untuk perangkat berisiko tinggi, selalu konsultasikan dengan teknisi berpengalaman.
            </p>
        </div>

    </div>
</footer>
