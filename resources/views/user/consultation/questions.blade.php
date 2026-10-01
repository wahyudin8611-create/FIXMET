@extends('layouts.app')
@section('title', 'Pertanyaan Diagnosis')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Jawab Pertanyaan Berikut</h1>
        <p class="text-gray-500 text-sm mt-1">Perangkat: <strong>{{ $consultation->device->name }}</strong> ({{ $consultation->consultation_code }})</p>
    </div>

    @if($symptoms->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <p class="text-yellow-700 font-medium">Belum ada gejala untuk perangkat ini.</p>
            <p class="text-yellow-600 text-sm mt-1">Silakan hubungi admin untuk menambahkan data gejala.</p>
            <form action="{{ route('user.diagnosis.answers', $consultation->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-yellow-600">Proses Tanpa Gejala</button>
            </form>
        </div>
    @else
        <form action="{{ route('user.diagnosis.answers', $consultation->id) }}" method="POST" class="space-y-4">
            @csrf
            @foreach($symptoms as $i => $symptom)
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <p class="font-medium text-gray-900 mb-3">{{ $i + 1 }}. {{ $symptom->name }}</p>
                @if($symptom->description)
                    <p class="text-sm text-gray-500 mb-3">{{ $symptom->description }}</p>
                @endif
                <div class="flex gap-3">
                    <label class="flex items-center gap-2 cursor-pointer flex-1 border rounded-lg p-3 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="symptom_{{ $symptom->id }}" value="1" class="text-green-600" required>
                        <span class="text-sm font-medium text-gray-700">✅ Ya</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer flex-1 border rounded-lg p-3 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                        <input type="radio" name="symptom_{{ $symptom->id }}" value="0" class="text-red-600">
                        <span class="text-sm font-medium text-gray-700">❌ Tidak</span>
                    </label>
                </div>
            </div>
            @endforeach

            <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700 transition">
                Analisis Kerusakan →
            </button>
        </form>
    @endif
</div>
@endsection
