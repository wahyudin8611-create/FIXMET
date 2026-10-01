@extends('layouts.admin')
@section('title', 'Edit Aturan')
@section('page-title', 'Rule Builder — Edit Aturan')
@section('content')
<div class="max-w-3xl" x-data="ruleBuilderEdit()">
    <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Informasi Dasar</h2>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aturan</label>
                    <input type="text" name="rule_code" value="{{ old('rule_code', $rule->rule_code) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confidence Base Weight</label>
                    <input type="number" name="confidence_weight" value="{{ old('confidence_weight', $rule->confidence_weight) }}" min="0.1" max="1.0" step="0.05"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat</label>
                <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700">
                    {{ $rule->diagnosis->device->name }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis (THEN) <span class="text-red-500">*</span></label>
                <select name="diagnosis_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($diagnoses as $d)
                    <option value="{{ $d->id }}" {{ old('diagnosis_id', $rule->diagnosis_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-3">
            <h2 class="font-semibold text-gray-900">Kondisi (IF)</h2>
            @foreach($symptoms as $s)
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="symptom_ids[]" value="{{ $s->id }}"
                    {{ in_array($s->id, $selectedSymptomIds) ? 'checked' : '' }}
                    class="w-4 h-4 text-primary-600 rounded">
                <div>
                    <span class="font-mono text-xs text-gray-400 mr-2">{{ $s->code }}</span>
                    <span class="text-sm text-gray-900">{{ $s->question }}</span>
                </div>
            </label>
            @endforeach
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Update Aturan</button>
            <a href="{{ route('admin.rules.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
