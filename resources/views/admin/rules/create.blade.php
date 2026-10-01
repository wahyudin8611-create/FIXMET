@extends('layouts.admin')
@section('title', 'Tambah Aturan')
@section('page-title', 'Rule Builder — Tambah Aturan Pakar')
@section('content')
<div class="max-w-3xl" x-data="ruleBuilder()">
    <form action="{{ route('admin.rules.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Informasi Dasar</h2>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perangkat <span class="text-red-500">*</span></label>
                    <select name="device_id" x-model="deviceId" @change="loadSymptoms(); loadDiagnoses()" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Perangkat --</option>
                        @foreach($devices as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aturan <span class="text-red-500">*</span></label>
                    <input type="text" name="rule_code" value="{{ old('rule_code') }}" required placeholder="R001"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis (THEN) <span class="text-red-500">*</span></label>
                <select name="diagnosis_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" :disabled="!deviceId">
                    <option value="">-- Pilih terlebih dahulu perangkat --</option>
                    <template x-for="d in diagnoses" :key="d.id">
                        <option :value="d.id" x-text="d.name"></option>
                    </template>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confidence Base Weight (0.1 – 1.0)</label>
                <input type="number" name="confidence_weight" value="{{ old('confidence_weight', 0.8) }}" min="0.1" max="1.0" step="0.05"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Nilai awal sebelum dikalikan rasio gejala yang cocok</p>
            </div>
        </div>

        {{-- Symptom Builder --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-3">
            <h2 class="font-semibold text-gray-900">Kondisi (IF) — Gejala yang Harus Terpenuhi</h2>
            <p class="text-xs text-gray-500">Semua gejala yang dipilih harus bernilai "Ya" (strict AND logic).</p>

            <div x-show="!deviceId" class="text-center text-gray-400 text-sm py-4">Pilih perangkat dahulu untuk melihat gejala yang tersedia</div>

            <div x-show="deviceId && symptoms.length === 0" class="text-center text-gray-400 text-sm py-4">Tidak ada gejala tersedia untuk perangkat ini</div>

            <div x-show="symptoms.length > 0" class="space-y-2">
                <template x-for="s in symptoms" :key="s.id">
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="symptom_ids[]" :value="s.id"
                            :checked="selectedSymptoms.includes(s.id)"
                            @change="toggleSymptom(s.id)"
                            class="w-4 h-4 text-primary-600 rounded">
                        <div class="flex-1">
                            <span class="font-mono text-xs text-gray-400 mr-2" x-text="s.code"></span>
                            <span class="text-sm text-gray-900" x-text="s.question"></span>
                        </div>
                    </label>
                </template>
            </div>

            <div x-show="selectedSymptoms.length > 0" class="bg-blue-50 rounded-lg p-3 text-xs text-blue-700">
                <strong x-text="selectedSymptoms.length + ' gejala dipilih'"></strong> — Rule akan aktif hanya jika semua gejala ini dijawab "Ya"
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Simpan Aturan</button>
            <a href="{{ route('admin.rules.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function ruleBuilder() {
    return {
        deviceId: '',
        symptoms: [],
        diagnoses: [],
        selectedSymptoms: [],
        async loadSymptoms() {
            if (!this.deviceId) { this.symptoms = []; return; }
            const res = await fetch(`/admin/rules/symptoms/${this.deviceId}`);
            this.symptoms = await res.json();
        },
        async loadDiagnoses() {
            if (!this.deviceId) { this.diagnoses = []; return; }
            const res = await fetch(`/admin/rules/diagnoses/${this.deviceId}`);
            this.diagnoses = await res.json();
        },
        toggleSymptom(id) {
            const idx = this.selectedSymptoms.indexOf(id);
            if (idx >= 0) this.selectedSymptoms.splice(idx, 1);
            else this.selectedSymptoms.push(id);
        }
    }
}
</script>
@endpush
@endsection
