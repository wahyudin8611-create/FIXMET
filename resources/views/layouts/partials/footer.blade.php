<footer class="border-t border-gray-100 bg-fm-dark text-gray-400 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-14">
        <div class="grid md:grid-cols-4 gap-10 mb-12">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <x-logo-mark class="w-9 h-9" />
                    <span class="font-extrabold text-xl text-white tracking-tight">FIX<span class="text-fm-primary-light">MATE</span></span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs mb-5">
                    Platform diagnosis kerusakan perangkat berbasis foto dan sistem pakar. Diagnose. Repair. Connect.
                </p>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium" style="background: rgba(61,139,122,0.15); color: #5BA897;">
                        <div class="w-1.5 h-1.5 rounded-full bg-fm-primary-light animate-pulse"></div>
                        Sistem Aktif 24/7
                    </div>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Platform</h4>
                <ul class="space-y-3">
                    @foreach([['Cara Kerja', 'how-it-works'],['Teknisi Kami', 'technicians.index'],['Tentang Kami', 'about']] as [$label, $route])
                    <li><a href="{{ route($route) }}" class="text-sm text-gray-500 hover:text-gray-200 transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- CTA --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Mulai Sekarang</h4>
                <div class="space-y-3">
                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-bold text-white rounded-xl bg-fm-primary hover:bg-fm-primary-dark transition-all hover:-translate-y-0.5 hover:shadow-lg">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-gray-300 rounded-xl border border-gray-700 hover:border-gray-500 hover:text-white transition-all">
                        Masuk Akun
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-600">&copy; {{ date('Y') }} FIXMATE · Dibuat di Indonesia</p>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-600">Teknologi Indonesia</span>
                <div class="flex items-center gap-1.5">
                    <div class="w-4 h-4 rounded-full bg-fm-primary"></div>
                    <span class="text-xs text-gray-600">Expert System</span>
                </div>
            </div>
        </div>
    </div>
</footer>
