@extends('layouts.admin')
@section('title', 'Tambah Gejala')
@section('page-title', 'Tambah Gejala')
@section('content')
<div class="max-w-lg">
    <form action="{{ route('admin.symptoms.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat <span class="text-red-500">*</span></label>
                <select name="device_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Pilih Perangkat --</option>
                    @foreach($devices as $d)
                    <option value="{{ $d->id }}" {{ old('device_id') == $d->id ? 'selected' : '' }}>{{ $d->name }} ({{ $d->category->name }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Gejala <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="contoh: G001" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <input type="text" name="question" value="{{ old('question') }}" required
                    placeholder="Apakah perangkat sering restart sendiri?"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bobot (1-10)</label>
                <input type="number" name="weight" value="{{ old('weight', 1) }}" min="1" max="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Simpan</button>
            <a href="{{ route('admin.symptoms.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
