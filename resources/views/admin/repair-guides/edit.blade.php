@extends('layouts.admin')
@section('title', 'Edit Panduan')
@section('page-title', 'Edit Panduan Perbaikan')
@section('content')
<div class="max-w-3xl" x-data="{ steps: @json($guide->steps->map(fn($s) => ['id' => $s->id, 'step_number' => $s->step_number, 'title' => $s->title, 'description' => $s->description, 'warning' => $s->warning ?? ''])) }">
    <form action="{{ route('admin.repair-guides.update', $guide->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <h2 class="font-semibold text-gray-900">Informasi Panduan</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                <select name="diagnosis_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($diagnoses as $d)
                    <option value="{{ $d->id }}" {{ old('diagnosis_id', $guide->diagnosis_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title', $guide->title) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $guide->description) }}</textarea>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
                    <select name="difficulty" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach(['easy','medium','hard'] as $d)
                        <option value="{{ $d }}" {{ old('difficulty', $guide->difficulty) === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi (mnt)</label>
                    <input type="number" name="estimated_time" value="{{ old('estimated_time', $guide->estimated_time) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost Range</label>
                    <input type="text" name="cost_range" value="{{ old('cost_range', $guide->cost_range) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alat yang Dibutuhkan</label>
                <textarea name="tools_needed" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('tools_needed', $guide->tools_needed) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Yang Tidak Boleh Dilakukan</label>
                <textarea name="do_not_do" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('do_not_do', $guide->do_not_do) }}</textarea>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-3">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Langkah-Langkah</h2>
                <button type="button" @click="steps.push({ step_number: steps.length + 1, title: '', description: '', warning: '' })"
                    class="text-sm text-primary-600 font-medium hover:text-primary-700">+ Tambah Langkah</button>
            </div>
            <template x-for="(step, idx) in steps" :key="idx">
                <div class="border border-gray-200 rounded-lg p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-sm text-gray-700" x-text="'Langkah ' + step.step_number"></span>
                        <button type="button" @click="steps.splice(idx, 1); steps.forEach((s,i) => s.step_number = i+1)"
                            x-show="steps.length > 1" class="text-red-400 hover:text-red-600 text-xs">Hapus</button>
                    </div>
                    <input type="hidden" :name="'steps[' + idx + '][id]'" :value="step.id ?? ''">
                    <input type="hidden" :name="'steps[' + idx + '][step_number]'" :value="step.step_number">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                        <input type="text" :name="'steps[' + idx + '][title]'" x-model="step.title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Instruksi</label>
                        <textarea :name="'steps[' + idx + '][description]'" x-model="step.description" rows="2" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Peringatan</label>
                        <input type="text" :name="'steps[' + idx + '][warning]'" x-model="step.warning" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
            </template>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Update Panduan</button>
            <a href="{{ route('admin.repair-guides.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
