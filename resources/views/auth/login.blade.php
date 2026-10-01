@extends('layouts.auth')
@section('title', 'Masuk ke FIXMET')
@section('content')
<div class="min-h-screen flex" x-data="{ showPass: false }">

    {{-- ── LEFT PANEL: dark brand panel ── --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[45%] relative overflow-hidden flex-col justify-between p-12"
         style="background: linear-gradient(145deg, #0f1f1b 0%, #162e27 50%, #1A2332 100%);">

        {{-- Floating blobs --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-20"
             style="background: radial-gradient(circle, #3D8B7A, transparent 70%);"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 rounded-full opacity-15"
             style="background: radial-gradient(circle, #E2B85B, transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full opacity-10"
             style="background: radial-gradient(circle, #3D8B7A, transparent 60%);"></div>

        {{-- Grid dots decoration --}}
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

        {{-- Logo --}}
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg"
                     style="background: #3D8B7A; box-shadow: 0 8px 20px rgba(61,139,122,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl tracking-tight group-hover:text-emerald-300 transition-colors">FIXMET</span>
            </a>
        </div>

        {{-- Main brand copy --}}
        <div class="relative z-10">
            <div class="mb-8">
                <h1 class="text-5xl xl:text-6xl font-extrabold text-white leading-none mb-4 tracking-tight">
                    Diagnose.<br>
                    <span style="background: linear-gradient(90deg, #5BA897, #E2B85B); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Repair.
                    </span><br>
                    Connect.
                </h1>
                <p class="text-slate-400 text-lg leading-relaxed max-w-xs">
                    Platform cerdas untuk diagnosa kerusakan elektronik berbasis sistem pakar.
                </p>
            </div>

            {{-- Feature pills --}}
            <div class="space-y-3">
                @foreach([
                    ['🔧', 'Sistem Pakar', 'Forward chaining + confidence score'],
                    ['👨‍🔧', 'Teknisi Terverifikasi', 'Ribuan teknisi profesional di seluruh Indonesia'],
                    ['📖', 'Panduan Perbaikan', 'Ribuan panduan step-by-step untuk DIY'],
                ] as [$icon, $title, $sub])
                <div class="flex items-center gap-3 p-3 rounded-xl"
                     style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
                    <span class="text-2xl">{{ $icon }}</span>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $title }}</p>
                        <p class="text-slate-500 text-xs">{{ $sub }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative z-10">
            <p class="text-slate-700 text-xs">&copy; 2024 FIXMET &middot; Teknologi Indonesia</p>
        </div>
    </div>

    {{-- ── RIGHT PANEL: form ── --}}
    <div class="flex-1 flex items-center justify-center p-6 lg:p-14 bg-white min-h-screen">
        <div class="w-full max-w-[380px]">

            {{-- Mobile logo --}}
            <div class="lg:hidden mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-fm-primary">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900">FIXMET</span>
                </a>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat datang kembali</h2>
                <p class="text-gray-500 text-sm">Masuk ke akun FIXMET Anda untuk melanjutkan</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
            <div class="mb-5 flex items-start gap-3 p-4 bg-red-50 border border-red-100 rounded-xl">
                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-700 text-sm font-medium">{{ $errors->first() }}</p>
            </div>
            @endif

            @if(session('status'))
            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                <p class="text-emerald-700 text-sm font-medium">{{ session('status') }}</p>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-5 p-4 bg-fm-primary/5 border border-fm-primary/10 rounded-xl">
                <p class="text-fm-primary text-sm font-medium">{{ session('info') }}</p>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@email.com"
                               class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300 @error('email') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Password</label>
                        <a href="{{ route('password.request') }}"
                           class="text-xs font-medium text-fm-primary hover:text-fm-primary-dark hover:underline">
                            Lupa password?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" name="password" required
                               placeholder="••••••••"
                               class="ring-focus w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300">
                        <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <label class="flex items-center gap-2.5 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" id="remember" class="sr-only peer">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:bg-fm-primary peer-checked:border-fm-primary transition-all group-hover:border-fm-primary-light cursor-pointer flex items-center justify-center">
                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya selama 30 hari</span>
                </label>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full py-3.5 text-white font-semibold rounded-xl shadow-lg" style="box-shadow: 0 8px 20px rgba(61,139,122,0.2);">
                    Masuk ke Akun
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white text-gray-400">Belum punya akun?</span>
                </div>
            </div>

            <a href="{{ route('register') }}"
               class="flex items-center justify-center gap-2 w-full py-3.5 text-sm font-semibold text-gray-700 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 hover:border-gray-300 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Buat Akun Baru
            </a>
        </div>
    </div>
</div>
@endsection
