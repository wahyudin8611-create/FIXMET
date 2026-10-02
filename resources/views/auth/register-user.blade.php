@extends('layouts.auth')
@section('title', 'Daftar sebagai Pengguna - FIXMET')
@section('content')
<div class="min-h-screen flex" x-data="{ showPass: false, showConfirm: false }">

    {{-- ── LEFT decorative panel ── --}}
    <div class="hidden lg:flex lg:w-[40%] xl:w-[42%] relative overflow-hidden flex-col justify-between p-12"
         style="background: linear-gradient(145deg, #1a3a33 0%, #2A6356 45%, #3D8B7A 100%);">

        {{-- Decorative elements --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-20"
                 style="background: rgba(255,255,255,0.3);"></div>
            <div class="absolute bottom-10 -left-16 w-56 h-56 rounded-full opacity-15"
                 style="background: rgba(255,255,255,0.2);"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[450px] rounded-full opacity-5"
                 style="background: white;"></div>
            <div class="absolute inset-0 opacity-[0.05]"
                 style="background-image: radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 28px 28px;"></div>
        </div>

        {{-- Back link --}}
        <div class="relative z-10">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-emerald-200 hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke pilihan peran
            </a>
        </div>

        {{-- Content --}}
        <div class="relative z-10">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-8 shadow-2xl"
                 style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>

            <h2 class="text-3xl xl:text-4xl font-extrabold text-white mb-3 leading-tight tracking-tight">
                Daftar sebagai<br>
                <span class="text-emerald-200">Pengguna</span>
            </h2>
            <p class="text-emerald-200 mb-10 leading-relaxed">
                Buat akun dan mulai diagnosis perangkat Anda dalam hitungan menit.
            </p>

            {{-- Benefits --}}
            <div class="space-y-4">
                @foreach([
                    ['bolt', 'Diagnosis dalam 2 menit', 'Jawab beberapa pertanyaan singkat'],
                    ['search', 'Hasil akurat & detail', 'Confidence score + tingkat keparahan'],
                    ['wrench', 'Panduan perbaikan gratis', 'Step-by-step untuk perbaikan mandiri'],
                    ['shield-check', 'Teknisi terpercaya', '100+ teknisi terverifikasi siap membantu'],
                ] as [$icon, $title, $sub])
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0"><x-icon :name="$icon" class="w-4 h-4 text-white" /></span>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $title }}</p>
                        <p class="text-emerald-300 text-xs">{{ $sub }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 p-3 rounded-xl" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                <div class="flex -space-x-2">
                    @for($i = 0; $i < 4; $i++)
                    <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center text-xs font-bold text-white"
                         style="border-color: #2A6356; background: hsl({{ 150 + $i * 30 }}, 50%, 45%);">
                        {{ chr(65 + $i) }}
                    </div>
                    @endfor
                </div>
                <p class="text-emerald-100 text-xs">Bergabung dengan <strong>10.000+</strong> pengguna aktif</p>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: form panel ── --}}
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 bg-white min-h-screen">
        <div class="w-full max-w-[400px]">

            {{-- Mobile back --}}
            <div class="lg:hidden mb-6">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-fm-primary">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-fm-primary uppercase tracking-wide">Akun Pengguna</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Buat akun baru</h1>
                <p class="text-gray-500 text-sm">Gratis selamanya &middot; Tidak perlu kartu kredit</p>
            </div>

            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-xl">
                <p class="text-red-700 text-sm font-semibold mb-1">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li class="text-red-600 text-xs">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.user.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama sesuai KTP"
                               class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300 @error('name') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                               class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300 @error('email') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                               class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" name="password" required placeholder="Minimal 8 karakter"
                               class="ring-focus w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300 @error('password') border-red-400 bg-red-50 @enderror">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required placeholder="Ulangi password"
                               class="ring-focus w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full py-3.5 text-white font-bold rounded-xl shadow-lg text-sm" style="box-shadow: 0 8px 20px rgba(61,139,122,0.2);">
                        Buat Akun Sekarang &rarr;
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-3">Dengan mendaftar, Anda menyetujui syarat & ketentuan FIXMET.</p>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-fm-primary hover:text-fm-primary-dark">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
