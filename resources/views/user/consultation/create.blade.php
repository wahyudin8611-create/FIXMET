@extends('layouts.app')
@section('title', 'Mulai Diagnosis')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ auth()->user()?->isUser() ? route('user.dashboard') : route('home') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali</a>
        <h1 class="text-2xl font-bold mt-2">Mulai Diagnosis Kerusakan</h1>
        <p class="text-gray-500 text-sm mt-1">Upload foto kerusakan dan isi informasi perangkat Anda.</p>
    </div>

    <form action="{{ route('diagnosis.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="diagnosisForm">
        @csrf

        {{-- Photo Upload --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h2 class="font-semibold mb-1">Foto Kerusakan <span class="text-red-500">*</span></h2>
            <p class="text-sm text-gray-500 mb-3">Upload 1-5 foto kerusakan (JPG, PNG, WebP, maks 5MB/foto)</p>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-700 mb-3 space-y-1">
                <p class="font-medium">Panduan foto yang baik:</p>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    <li>Pastikan pencahayaan cukup dan foto tidak blur</li>
                    <li>Fokus pada bagian yang rusak</li>
                    <li>Ambil dari beberapa sudut jika memungkinkan</li>
                </ul>
            </div>

            <input type="file" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImages(event)">
            <div id="dropZone" onclick="document.getElementById('imageInput').click()"
                class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition">
                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                <p class="text-xs text-gray-400 mt-1">atau drag & drop di sini</p>
            </div>
            <div id="imagePreview" class="grid grid-cols-3 gap-2 mt-3"></div>
            @error('images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Device Info --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold">Informasi Perangkat</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" id="categorySelect" required onchange="loadDevices(this.value)"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-400 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat <span class="text-red-500">*</span></label>
                <select name="device_id" id="deviceSelect" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 @error('device_id') border-red-400 @enderror">
                    <option value="">-- Pilih Perangkat --</option>
                    @foreach($categories as $cat)
                        @foreach($cat->devices as $dev)
                        <option value="{{ $dev->id }}" data-cat="{{ $cat->id }}" {{ old('device_id') == $dev->id ? 'selected' : '' }} class="device-opt cat-{{ $cat->id }}">{{ $dev->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                @error('device_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" name="device_brand" value="{{ old('device_brand') }}" placeholder="contoh: ASUS"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                    <input type="text" name="device_model" value="{{ old('device_model') }}" placeholder="contoh: VivoBook"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Usia Perangkat (tahun)</label>
                <input type="number" name="device_age" value="{{ old('device_age') }}" min="0" max="50" placeholder="0"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan / Gejala <span class="text-red-500">*</span></label>
                <textarea name="initial_complaint" rows="3" required placeholder="Jelaskan keluhan Anda secara detail..." maxlength="1000"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 @error('initial_complaint') border-red-400 @enderror">{{ old('initial_complaint') }}</textarea>
                @error('initial_complaint') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700 transition">
            Lanjutkan ke Pertanyaan Diagnosis →
        </button>
    </form>
</div>

@push('scripts')
<script>
function previewImages(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    const files = e.target.files;
    if (files.length > 5) {
        alert('Maksimal 5 foto');
        e.target.value = '';
        return;
    }
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = ev => {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${ev.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function loadDevices(categoryId) {
    const select = document.getElementById('deviceSelect');
    const opts = select.querySelectorAll('option');
    opts.forEach(opt => {
        if (opt.value === '') return;
        opt.style.display = (opt.dataset.cat === categoryId) ? '' : 'none';
    });
    select.value = '';
}
</script>
@endpush
@endsection
