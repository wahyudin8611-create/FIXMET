@extends('layouts.admin')
@section('title', 'Edit Diagnosis')
@section('page-title', 'Edit Diagnosis')
@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.diagnoses.update', $diagnosis->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat <span class="text-red-500">*</span></label>
                    <select name="device_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach($devices as $d)
                        <option value="{{ $d->id }}" {{ old('device_id', $diagnosis->device_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $diagnosis->code) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diagnosis <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $diagnosis->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $diagnosis->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
                    <select name="severity" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach(['low','medium','high','critical'] as $s)
                        <option value="{{ $s }}" {{ old('severity', $diagnosis->severity) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Repairability</label>
                    <select name="repairability" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach(['self_repair','professional_only','do_not_repair'] as $r)
                        <option value="{{ $r }}" {{ old('repairability', $diagnosis->repairability) === $r ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($r)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi</label>
                <textarea name="recommendation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('recommendation', $diagnosis->recommendation) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanda Bahaya</label>
                <textarea name="danger_signs" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('danger_signs', $diagnosis->danger_signs) }}</textarea>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Update</button>
            <a href="{{ route('admin.diagnoses.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
