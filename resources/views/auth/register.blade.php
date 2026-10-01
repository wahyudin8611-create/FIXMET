@extends('layouts.auth')
@section('title', 'Daftar FIXMET')
@section('content')
<div class="min-h-screen flex flex-col"
     style="background: linear-gradient(145deg, #f0f5f3 0%, #f5f6f3 50%, #f2f5f0 100%);">

    {{-- Decorative background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full opacity-30"
             style="background: radial-gradient(circle, rgba(61,139,122,0.2), transparent 70%);"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full opacity-20"
             style="background: radial-gradient(circle, rgba(226,184,91,0.2), transparent 70%);"></div>
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: radial-gradient(circle, #3D8B7A 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    {{-- Top bar --}}
    <div class="relative z-10 flex items-center justify-between px-6 md:px-10 py-5">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-md bg-fm-primary">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-lg group-hover:text-fm-primary transition-colors">FIXMET</span>
        </a>
        <a href="{{ route('login') }}"
           class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
            Sudah punya akun?
            <span class="font-semibold text-fm-primary hover:text-fm-primary-dark">Masuk</span>
        </a>
    </div>

    {{-- Main --}}
    <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-6 py-8 md:py-12">

        {{-- Header --}}
        <div class="text-center mb-10 md:mb-12">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold mb-5 tracking-wide"
                 style="background: rgba(61,139,122,0.1); color: #2A6356; border: 1px solid rgba(61,139,122,0.2);">
                ✦ Pilih peran Anda
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">
                Daftar sebagai apa?
            </h1>
            <p class="text-gray-500 max-w-md mx-auto leading-relaxed">
                Proses pendaftaran dan fitur masing-masing peran berbeda. Pilih yang sesuai dengan Anda.
            </p>
        </div>

        {{-- Cards --}}
        <div class="grid md:grid-cols-2 gap-5 md:gap-6 w-full max-w-3xl">

            {{-- ── User Card ── --}}
            <a href="{{ route('register.user') }}"
               class="group relative bg-white rounded-2xl p-7 md:p-8 border-2 border-transparent shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"
               style="box-shadow: 0 1px 3px rgba(0,0,0,0.08);"
               onmouseover="this.style.borderColor='#3D8B7A'; this.style.boxShadow='0 20px 40px rgba(61,139,122,0.12)'"
               onmouseout="this.style.borderColor='transparent'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)'">

                {{-- Hover overlay --}}
                <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                     style="background: linear-gradient(135deg, rgba(61,139,122,0.03), rgba(91,168,151,0.03));"></div>

                <div class="relative">
                    {{-- Icon --}}
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 group-hover:scale-110"
                         style="background: linear-gradient(135deg, #3D8B7A, #5BA897); box-shadow: 0 8px 20px rgba(61,139,122,0.3);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>

                    <div class="mb-1">
                        <span class="inline-block px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-fm-primary mb-2">Pengguna</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Saya Pengguna</h2>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                        Perangkat saya bermasalah dan ingin diagnosis atau mencari teknisi reparasi.
                    </p>

                    <ul class="space-y-2.5 mb-8">
                        @foreach([
                            'Diagnosis sistem pakar gratis & akurat',
                            'Panduan perbaikan mandiri',
                            'Booking teknisi terverifikasi',
                            'Riwayat konsultasi lengkap',
                        ] as $item)
                        <li class="flex items-center gap-2.5 text-sm text-gray-600">
                            <div class="w-5 h-5 bg-emerald-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-fm-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-fm-primary group-hover:text-fm-primary-dark transition-colors">
                            Daftar sebagai Pengguna
                        </span>
                        <div class="w-9 h-9 rounded-full bg-fm-primary flex items-center justify-center transition-all duration-300 group-hover:translate-x-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            {{-- ── Technician Card ── --}}
            <a href="{{ route('register.technician') }}"
               class="group relative bg-white rounded-2xl p-7 md:p-8 border-2 border-transparent shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"
               style="box-shadow: 0 1px 3px rgba(0,0,0,0.08);"
               onmouseover="this.style.borderColor='#E2B85B'; this.style.boxShadow='0 20px 40px rgba(226,184,91,0.12)'"
               onmouseout="this.style.borderColor='transparent'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)'">

                <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                     style="background: linear-gradient(135deg, rgba(226,184,91,0.03), rgba(212,166,62,0.03));"></div>

                <div class="relative">
                    {{-- Icon --}}
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 group-hover:scale-110"
                         style="background: linear-gradient(135deg, #E2B85B, #D4A63E); box-shadow: 0 8px 20px rgba(226,184,91,0.3);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                        </svg>
                    </div>

                    <div class="mb-1">
                        <span class="inline-block px-2 py-0.5 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 mb-2">Mitra Teknisi</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Saya Teknisi</h2>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                        Saya punya keahlian reparasi elektronik dan ingin menerima pelanggan.
                    </p>

                    <ul class="space-y-2.5 mb-8">
                        @foreach([
                            'Terima booking dari pelanggan terdekat',
                            'Profil teknisi terverifikasi resmi',
                            'Sistem rating & ulasan pelanggan',
                            'Manajemen jadwal fleksibel',
                        ] as $item)
                        <li class="flex items-center gap-2.5 text-sm text-gray-600">
                            <div class="w-5 h-5 bg-amber-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-bold text-amber-600 group-hover:text-amber-700 transition-colors block">
                                Daftar sebagai Teknisi
                            </span>
                            <span class="text-xs text-gray-400">Perlu verifikasi dokumen</span>
                        </div>
                        <div class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300 group-hover:translate-x-1"
                             style="background: linear-gradient(135deg, #E2B85B, #D4A63E);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Footer note --}}
        <p class="mt-8 text-center text-xs text-gray-400 max-w-sm">
            Dengan mendaftar, Anda menyetujui
            <span class="text-gray-600 font-medium">Syarat & Ketentuan</span> dan
            <span class="text-gray-600 font-medium">Kebijakan Privasi</span> FIXMET.
        </p>
    </div>
</div>
@endsection
