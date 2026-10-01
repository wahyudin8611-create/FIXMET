@extends('layouts.admin')
@section('title', 'Tambah Diagnosis')
@section('page-title', 'Tambah Diagnosis')
@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.diagnoses.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat <span class="text-red-500">*</span></label>
                    <select name="device_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Perangkat --</option>
                        @foreach($devices as $d)
                        <option value="{{ $d->id }}" {{ old('device_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Diagnosis <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" required placeholder="D001" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diagnosis <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Severity <span class="text-red-500">*</span></label>
                    <select name="severity" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Repairability <span class="text-red-500">*</span></label>
                    <select name="repairability" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="self_repair" {{ old('repairability') === 'self_repair' ? 'selected' : '' }}>Self Repair</option>
                        <option value="professional_only" {{ old('repairability') === 'professional_only' ? 'selected' : '' }}>Professional Only</option>
                        <option value="do_not_repair" {{ old('repairability') === 'do_not_repair' ? 'selected' : '' }}>Do Not Repair</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi</label>
                <textarea name="recommendation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('recommendation') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanda Bahaya</label>
                <textarea name="danger_signs" rows="2" placeholder="Tanda yang perlu segera ditangani..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('danger_signs') }}</textarea>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Simpan</button>
            <a href="{{ route('admin.diagnoses.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
