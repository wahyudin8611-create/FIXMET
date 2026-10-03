@extends('layouts.auth')
@section('title', 'Daftar sebagai Teknisi - FIXMATE')
@section('content')

@push('styles')
<style>
    .step-circle { transition: all 0.3s ease; }
    .step-connector { transition: background 0.3s ease; }
    .slide-enter { animation: slideIn 0.3s ease; }
    @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    .upload-zone { border: 2px dashed #d1d5db; transition: all 0.2s ease; }
    .upload-zone:hover { border-color: #3D8B7A; background: #f0fdf4; }
    .file-selected { border-color: #3D8B7A !important; background: #f0fdf4 !important; }
</style>
@endpush

<div class="min-h-screen bg-white" x-data="technicianForm()">

    {{-- ── TOP HEADER ── --}}
    <div class="border-b border-gray-100 px-6 py-4">
        <div class="max-w-2xl mx-auto flex items-center justify-between">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #E2B85B, #D4A63E);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-sm">FIXMATE <span class="text-fm-primary">Teknisi</span></span>
            </div>
        </div>
    </div>

    {{-- ── STEP INDICATOR ── --}}
    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-5">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center">
                @php $steps = ['Akun', 'Profesi', 'Dokumen']; @endphp
                @foreach($steps as $i => $label)
                    <div class="flex flex-col items-center">
                        <div class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all"
                             :class="{
                                 'bg-fm-primary border-fm-primary text-white': step > {{ $i + 1 }},
                                 'bg-fm-primary border-fm-primary text-white shadow-lg': step === {{ $i + 1 }},
                                 'bg-white border-gray-200 text-gray-400': step < {{ $i + 1 }}
                             }"
                             :style="step === {{ $i + 1 }} ? 'box-shadow: 0 8px 20px rgba(61,139,122,0.3)' : ''">
                            <template x-if="step > {{ $i + 1 }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </template>
                            <template x-if="step <= {{ $i + 1 }}">
                                <span>{{ $i + 1 }}</span>
                            </template>
                        </div>
                        <span class="text-xs mt-1.5 font-medium transition-colors"
                              :class="step >= {{ $i + 1 }} ? 'text-fm-primary' : 'text-gray-400'">
                            {{ $label }}
                        </span>
                    </div>
                    @if($i < count($steps) - 1)
                    <div class="flex-1 h-0.5 mx-2 mb-4 rounded-full transition-all step-connector"
                         :class="step > {{ $i + 1 }} ? 'bg-fm-primary' : 'bg-gray-200'"></div>
                    @endif
                @endforeach
            </div>

            <div class="mt-3">
                <p class="text-sm text-gray-500" x-show="step === 1" x-cloak>Buat akun untuk mengakses platform FIXMATE</p>
                <p class="text-sm text-gray-500" x-show="step === 2" x-cloak>Informasi profesional untuk ditampilkan ke pelanggan</p>
                <p class="text-sm text-gray-500" x-show="step === 3" x-cloak>Unggah dokumen verifikasi identitas dan keahlian</p>
            </div>
        </div>
    </div>

    {{-- ── FORM CONTENT ── --}}
    <div class="px-6 py-8">
        <div class="max-w-2xl mx-auto">

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                <p class="text-red-700 text-sm font-semibold mb-1">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li class="text-red-600 text-xs">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.technician.store') }}" method="POST" enctype="multipart/form-data"
                  @submit.prevent="submitForm($el)">
                @csrf

                {{-- ═══ STEP 1: AKUN ═══ --}}
                <div x-show="step === 1" class="slide-enter">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Informasi Akun</h2>
                    <p class="text-gray-500 text-sm mb-6">Lengkapi data dasar untuk membuat akun teknisi</p>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <input type="text" name="name" x-ref="name" value="{{ old('name') }}" placeholder="Nama sesuai KTP" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.name ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p x-show="errs.name" x-text="errs.name" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                                <input type="email" name="email" x-ref="email" value="{{ old('email') }}" placeholder="nama@email.com" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.email ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p x-show="errs.email" x-text="errs.email" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                                <input type="text" name="phone" x-ref="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.phone ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p x-show="errs.phone" x-text="errs.phone" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                                <input :type="showPass ? 'text' : 'password'" name="password" x-ref="password" placeholder="Min. 8 karakter" class="ring-focus w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.password ? 'border-red-400 bg-red-50' : ''">
                                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <p x-show="errs.password" x-text="errs.password" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-ref="confirm" placeholder="Ulangi password" class="ring-focus w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.confirm ? 'border-red-400 bg-red-50' : ''">
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <p x-show="errs.confirm" x-text="errs.confirm" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>
                    </div>
                </div>

                {{-- ═══ STEP 2: PROFESI ═══ --}}
                <div x-show="step === 2" class="slide-enter" x-cloak>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Informasi Profesional</h2>
                    <p class="text-gray-500 text-sm mb-6">Data ini akan ditampilkan ke calon pelanggan Anda</p>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Spesialisasi / Keahlian Utama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg></div>
                                <input type="text" name="specialization" x-ref="spec" value="{{ old('specialization') }}" placeholder="cth: Laptop & Komputer, AC Rumah, Smartphone" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.spec ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p x-show="errs.spec" x-text="errs.spec" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Area Layanan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                                <input type="text" name="service_area" x-ref="area" value="{{ old('service_area') }}" placeholder="cth: Jakarta Selatan, Depok" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.area ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p x-show="errs.area" x-text="errs.area" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pengalaman (tahun)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                <input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" max="50" placeholder="0" class="ring-focus w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Biaya Servis (per kunjungan)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-gray-500 text-sm font-medium">Rp</div>
                                <input type="number" name="service_fee" x-ref="fee" value="{{ old('service_fee', 0) }}" min="0" placeholder="50000" class="ring-focus w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300" :class="errs.fee ? 'border-red-400 bg-red-50' : ''">
                            </div>
                            <p class="text-gray-400 text-xs mt-1">Masukkan 0 jika gratis / bayar di tempat sesuai kesepakatan</p>
                            <p x-show="errs.fee" x-text="errs.fee" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Diri <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="description" rows="3" placeholder="Ceritakan tentang pengalaman dan keahlian Anda kepada calon pelanggan..." class="ring-focus w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm transition-all hover:border-gray-300 resize-none">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ═══ STEP 3: DOKUMEN ═══ --}}
                <div x-show="step === 3" class="slide-enter" x-cloak>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Upload Dokumen Verifikasi</h2>
                    <p class="text-gray-500 text-sm mb-2">Dokumen diperlukan untuk verifikasi oleh tim FIXMATE</p>

                    <div class="p-3.5 mb-6 bg-amber-50 border border-amber-100 rounded-xl flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="text-amber-800 text-xs font-semibold">Proses verifikasi 1&ndash;3 hari kerja</p>
                            <p class="text-amber-700 text-xs mt-0.5">Akun Anda akan diaktifkan sebagai teknisi setelah dokumen diverifikasi admin.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">KTP / Kartu Identitas <span class="text-red-500">*</span> <span class="ml-1 text-xs font-normal text-gray-400">Wajib</span></label>
                            <label class="upload-zone rounded-xl p-6 flex flex-col items-center gap-3 cursor-pointer" :class="files.identity_card ? 'file-selected' : ''" x-ref="identityZone">
                                <input type="file" name="identity_card" class="sr-only" accept=".jpg,.jpeg,.png,.pdf" @change="handleFile($event, 'identity_card')">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center" :class="files.identity_card ? 'bg-emerald-100' : 'bg-gray-100'">
                                    <svg class="w-6 h-6" :class="files.identity_card ? 'text-fm-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-semibold text-gray-700" x-text="files.identity_card ? files.identity_card : 'Klik untuk unggah KTP'"></p>
                                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, PDF &middot; maks. 2MB</p>
                                </div>
                            </label>
                            <p x-show="errs.identity_card" x-text="errs.identity_card" class="text-red-500 text-xs mt-1" x-cloak></p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Sertifikat Keahlian <span class="text-xs font-normal text-gray-400">Opsional</span></label>
                                <label class="upload-zone rounded-xl p-5 flex flex-col items-center gap-2.5 cursor-pointer" :class="files.certificate ? 'file-selected' : ''">
                                    <input type="file" name="certificate" class="sr-only" accept=".jpg,.jpeg,.png,.pdf" @change="handleFile($event, 'certificate')">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" :class="files.certificate ? 'bg-emerald-100' : 'bg-gray-100'">
                                        <svg class="w-5 h-5" :class="files.certificate ? 'text-fm-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs font-semibold text-gray-700" x-text="files.certificate ? files.certificate : 'Unggah Sertifikat'"></p>
                                        <p class="text-xs text-gray-400">JPG, PNG, PDF &middot; 2MB</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Bukti Keahlian <span class="text-xs font-normal text-gray-400">Opsional</span></label>
                                <label class="upload-zone rounded-xl p-5 flex flex-col items-center gap-2.5 cursor-pointer" :class="files.skill_evidence ? 'file-selected' : ''">
                                    <input type="file" name="skill_evidence" class="sr-only" accept=".jpg,.jpeg,.png,.pdf" @change="handleFile($event, 'skill_evidence')">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" :class="files.skill_evidence ? 'bg-emerald-100' : 'bg-gray-100'">
                                        <svg class="w-5 h-5" :class="files.skill_evidence ? 'text-fm-primary' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs font-semibold text-gray-700" x-text="files.skill_evidence ? files.skill_evidence : 'Foto Pekerjaan'"></p>
                                        <p class="text-xs text-gray-400">JPG, PNG, PDF &middot; 2MB</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── NAVIGATION BUTTONS ── --}}
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                    <button type="button" @click="prev()" x-show="step > 1" x-cloak
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali
                    </button>
                    <div x-show="step === 1" class="text-xs text-gray-400">Langkah 1 dari 3</div>

                    <button type="button" @click="next()" x-show="step < 3"
                            class="btn-primary inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl">
                        Lanjutkan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <button type="submit" x-show="step === 3" x-cloak :disabled="submitting"
                            class="btn-primary inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl disabled:opacity-60">
                        <span x-show="!submitting">Kirim Pendaftaran</span>
                        <span x-show="submitting" x-cloak>Mengirim...</span>
                        <svg x-show="!submitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-fm-primary hover:text-fm-primary-dark">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function technicianForm() {
    return {
        step: {{ $errors->any() ? 1 : 1 }},
        showPass: false,
        showConfirm: false,
        submitting: false,
        files: { identity_card: null, certificate: null, skill_evidence: null },
        errs: {},

        next() {
            this.errs = {};
            if (this.step === 1) {
                const name = this.$refs.name?.value?.trim() ?? '';
                const email = this.$refs.email?.value?.trim() ?? '';
                const phone = this.$refs.phone?.value?.trim() ?? '';
                const pass = this.$refs.password?.value ?? '';
                const conf = this.$refs.confirm?.value ?? '';

                if (!name) this.errs.name = 'Nama lengkap wajib diisi';
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) this.errs.email = 'Format email tidak valid';
                if (!phone) this.errs.phone = 'Nomor telepon wajib diisi';
                if (!pass || pass.length < 8) this.errs.password = 'Password minimal 8 karakter';
                if (pass !== conf) this.errs.confirm = 'Konfirmasi password tidak cocok';
            }
            if (this.step === 2) {
                const spec = this.$refs.spec?.value?.trim() ?? '';
                const area = this.$refs.area?.value?.trim() ?? '';
                const fee = this.$refs.fee?.value ?? '';

                if (!spec) this.errs.spec = 'Spesialisasi wajib diisi';
                if (!area) this.errs.area = 'Area layanan wajib diisi';
                if (fee === '' || parseFloat(fee) < 0) this.errs.fee = 'Biaya layanan tidak valid';
            }
            if (Object.keys(this.errs).length === 0) this.step++;
        },

        prev() {
            this.errs = {};
            this.step--;
        },

        handleFile(event, field) {
            const file = event.target.files[0];
            if (file) {
                this.files[field] = file.name;
            }
        },

        submitForm(form) {
            this.errs = {};
            if (!this.files.identity_card) {
                this.errs.identity_card = 'KTP wajib diunggah';
                return;
            }
            this.submitting = true;
            form.submit();
        }
    }
}
</script>
@endpush

@endsection
