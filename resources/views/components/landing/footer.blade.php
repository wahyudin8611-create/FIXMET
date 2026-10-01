<footer style="background:#f5f5f7; border-top: 1px solid rgba(0,0,0,.06);" role="contentinfo">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16">

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-4 lg:col-span-2">
                <a href="{{ route('home') }}" class="font-bold text-lg text-[#1d1d1f] block mb-3">FIXMATE</a>
                <p class="text-[#6e6e73] text-sm leading-relaxed max-w-xs mb-5">
                    Platform diagnosis kerusakan perangkat berbasis foto dan sistem pakar.
                    Diagnose. Repair. Connect.
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('register') }}" class="btn-pill btn-blue text-sm py-2 px-5">Mulai Diagnosis</a>
                    <a href="{{ route('login') }}" class="btn-pill btn-outline text-sm py-2 px-5">Masuk</a>
                </div>
            </div>

            {{-- Platform --}}
            <div>
                <p class="text-xs font-bold text-[#1d1d1f] tracking-widest uppercase mb-4">Platform</p>
                <ul class="space-y-2.5" role="list">
                    @foreach([['home','Beranda'],['about','Tentang'],['how-it-works','Cara Kerja'],['technicians.index','Teknisi']] as [$route, $label])
                    <li><a href="{{ route($route) }}" class="text-sm text-[#6e6e73] hover:text-[#0071e3] transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <p class="text-xs font-bold text-[#1d1d1f] tracking-widest uppercase mb-4">Akun</p>
                <ul class="space-y-2.5" role="list">
                    @foreach([['login','Masuk'],['register','Daftar Pengguna'],['register.technician','Daftar Teknisi']] as [$route, $label])
                    <li><a href="{{ route($route) }}" class="text-sm text-[#6e6e73] hover:text-[#0071e3] transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <p class="text-xs font-bold text-[#1d1d1f] tracking-widest uppercase mb-4">Legal</p>
                <ul class="space-y-2.5" role="list">
                    <li><span class="text-sm text-[#6e6e73]">Kebijakan Privasi</span></li>
                    <li><span class="text-sm text-[#6e6e73]">Syarat Penggunaan</span></li>
                </ul>
            </div>

        </div>

        {{-- Divider --}}
        <div style="height:1px;background:rgba(0,0,0,.08);margin-bottom:24px;" aria-hidden="true"></div>

        {{-- Bottom bar --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <p class="text-xs text-[#6e6e73]">
                &copy; {{ date('Y') }} FIXMATE. Hak cipta dilindungi undang-undang.
            </p>
            <p class="text-xs text-[#6e6e73] max-w-md leading-relaxed sm:text-right">
                ⚠️ <strong>Disclaimer:</strong> Hasil diagnosis adalah kemungkinan berdasarkan foto dan gejala yang dilaporkan, bukan kepastian teknis. Untuk perangkat berisiko tinggi, selalu konsultasikan dengan teknisi berpengalaman.
            </p>
        </div>

    </div>
</footer>
