@extends('layouts.admin')
@section('title', 'Tambah Solusi')
@section('page-title', 'Tambah Solusi')
@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.solutions.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis <span class="text-red-500">*</span></label>
                <select name="diagnosis_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Pilih Diagnosis --</option>
                    @foreach($diagnoses as $d)
                    <option value="{{ $d->id }}" {{ old('diagnosis_id') == $d->id ? 'selected' : '' }}>{{ $d->name }} ({{ $d->device->name }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Solusi <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Solusi</label>
                    <select name="solution_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach(['preventive', 'corrective', 'emergency'] as $t)
                        <option value="{{ $t }}" {{ old('solution_type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order_number" value="{{ old('order_number', 1) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Simpan</button>
            <a href="{{ route('admin.solutions.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
