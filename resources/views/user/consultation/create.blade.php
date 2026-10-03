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
        x-data="photoPicker()" @submit="submitting = true" @pageshow.window="submitting = false">
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

            <input type="file" name="images[]" id="imageInput" x-ref="input" multiple accept="image/jpeg,image/png,image/webp" class="hidden" @change="addPhotos($event.target.files)">
            <div id="dropZone" @click="$refs.input.click()"
                @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false"
                @drop.prevent="dragging = false; addPhotos($event.dataTransfer.files)"
                :class="dragging ? 'border-primary-500 bg-primary-50' : 'border-gray-300'"
                class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition">
                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                <p class="text-xs text-gray-400 mt-1">atau drag & drop di sini</p>
            </div>
            <div id="imagePreview" class="grid grid-cols-3 gap-2 mt-3">
                <template x-for="(photo, index) in photos" :key="photo.url">
                    <div class="relative">
                        <img :src="photo.url" :alt="'Foto ' + (index + 1)" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                        <button type="button" @click="removePhoto(index)" :aria-label="'Hapus foto ' + (index + 1)"
                            class="absolute top-1 right-1 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-red-600 transition">
                            <x-icon name="x" class="w-4 h-4" />
                        </button>
                    </div>
                </template>
            </div>
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
/**
 * Keeps the chosen or dropped photos in a list so each one can be removed,
 * and mirrors that list into the real file input that the form submits.
 */
function photoPicker() {
    return {
        submitting: false,
        dragging: false,
        maxPhotos: 5,
        allowedTypes: ['image/jpeg', 'image/png', 'image/webp'],
        photos: [],
        addPhotos(fileList) {
            const files = Array.from(fileList).filter(file => this.allowedTypes.includes(file.type));
            if (files.length < fileList.length) {
                alert('Hanya foto JPG, PNG, atau WebP yang bisa diunggah');
            }
            if (this.photos.length + files.length > this.maxPhotos) {
                alert('Maksimal ' + this.maxPhotos + ' foto');
            }
            files.slice(0, this.maxPhotos - this.photos.length).forEach(file => {
                this.photos.push({ file, url: URL.createObjectURL(file) });
            });
            this.syncInput();
        },
        removePhoto(index) {
            URL.revokeObjectURL(this.photos[index].url);
            this.photos.splice(index, 1);
            this.syncInput();
        },
        syncInput() {
            const transfer = new DataTransfer();
            this.photos.forEach(photo => transfer.items.add(photo.file));
            this.$refs.input.files = transfer.files;
        },
    };
}
</script>
@endpush
@endsection
