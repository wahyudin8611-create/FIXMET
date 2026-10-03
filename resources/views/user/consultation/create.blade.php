@extends('layouts.app')
@section('title', 'Mulai Diagnosis')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ auth()->user()?->isUser() ? route('user.dashboard') : route('home') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Kembali</a>
        <h1 class="text-2xl font-bold mt-2">Mulai Diagnosis Kerusakan</h1>
        <p class="text-gray-500 text-sm mt-1">Upload foto kerusakan dan ceritakan masalahnya. Tidak perlu memilih kategori, merek, atau model, karena sistem akan mengenali perangkatnya sendiri.</p>
    </div>

    <form action="{{ route('diagnosis.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="diagnosisForm"
        x-data="{ submitting: false }" @submit="submitting = true" @pageshow.window="submitting = false">
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

        {{-- Complaint --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <label for="initialComplaint" class="block font-semibold mb-1">Ceritakan Masalahnya <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500 mb-3">Sebutkan perangkatnya dan apa yang terjadi, dengan bahasa sehari-hari.</p>
            <textarea name="initial_complaint" id="initialComplaint" rows="4" required maxlength="1000"
                placeholder="Contoh: HP saya jatuh, layarnya retak dan sebagian tidak bisa disentuh."
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 @error('initial_complaint') border-red-400 @enderror">{{ old('initial_complaint') }}</textarea>
            @error('initial_complaint') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @if($devices->isNotEmpty())
            <p class="text-xs text-gray-400 mt-2">Saat ini FIXMATE dapat mendiagnosis: {{ $devices->pluck('name')->implode(', ') }}.</p>
            @endif
        </div>

        <button type="submit" :disabled="submitting"
            class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700 transition disabled:opacity-80 disabled:cursor-wait">
            <span x-show="!submitting">Lanjutkan ke Pertanyaan Diagnosis →</span>
            <span x-show="submitting" x-cloak class="inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                Mengunggah dan menganalisis foto...
            </span>
        </button>
        <p x-show="submitting" x-cloak class="text-center text-xs text-fm-muted -mt-2">
            Proses ini bisa memakan waktu hingga 30 detik. Mohon jangan menutup halaman.
        </p>
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
</script>
@endpush
@endsection
