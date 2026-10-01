@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Profil</h1>

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ auth()->user()->profile_photo_url }}" class="w-16 h-16 rounded-full" alt="">
                <div>
                    <label class="text-sm font-medium text-gray-700">Foto Profil</label>
                    <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" class="block text-sm text-gray-500 mt-1">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('address', auth()->user()->address) }}</textarea>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Ganti Password</h2>
            <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700">Simpan Perubahan</button>
    </form>
</div>
@endsection
