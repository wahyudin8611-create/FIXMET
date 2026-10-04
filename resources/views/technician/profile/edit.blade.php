@extends('layouts.technician')
@section('title', 'Profil Teknisi')
@section('page-title', 'Edit Profil Teknisi')
@section('content')
<div class="max-w-2xl">
    @if($technician->exists && $technician->status !== 'verified')
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-4 text-sm text-yellow-700"><x-icon name="clock" class="inline w-4 h-4 mr-1 align-text-bottom" />Menunggu verifikasi admin.</div>
    @endif

    <form action="{{ route('technician.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Informasi Akun</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required maxlength="100"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">Nama ini dilihat pengguna di daftar teknisi, booking, dan chat.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Informasi Profesional</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi <span class="text-red-500">*</span></label>
                <input type="text" name="specialization" value="{{ old('specialization', $technician->specialization) }}" required
                    placeholder="contoh: AC & Refrigeration, Laptop & Komputer"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">{{ old('description', $technician->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Layanan (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="service_fee" value="{{ old('service_fee', $technician->service_fee ?? 75000) }}" min="0" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman (tahun) <span class="text-red-500">*</span></label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $technician->experience_years ?? 0) }}" min="0" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Area Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="service_area" value="{{ old('service_area', $technician->service_area) }}" required
                    placeholder="contoh: Karawang, Bekasi"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Dokumen Verifikasi</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">KTP / Identitas</label>
                <input type="file" name="identity_card" accept="image/jpeg,image/png" class="text-sm w-full">
                @if($technician->identity_card)
                <p class="text-xs text-green-600 mt-1"><x-icon name="check" class="inline w-4 h-4 mr-1 align-text-bottom" />File sudah ada</p>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikat Keahlian</label>
                <input type="file" name="certificate" accept="image/jpeg,image/png,.pdf" class="text-sm w-full">
                @if($technician->certificate)
                <p class="text-xs text-green-600 mt-1"><x-icon name="check" class="inline w-4 h-4 mr-1 align-text-bottom" />File sudah ada</p>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Keahlian / Portofolio</label>
                <input type="file" name="skill_evidence" accept="image/jpeg,image/png,.pdf" class="text-sm w-full">
                @if($technician->skill_evidence)
                <p class="text-xs text-green-600 mt-1"><x-icon name="check" class="inline w-4 h-4 mr-1 align-text-bottom" />File sudah ada</p>
                @endif
            </div>
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700">Simpan Profil</button>
    </form>
</div>
@endsection
