@extends('layouts.app')
@section('title', 'Pertanyaan Diagnosis')
@section('content')
@php
    $sourceLabels = [
        \App\Models\ConsultationAnswer::SOURCE_COMPLAINT => 'Dari keluhan Anda',
        \App\Models\ConsultationAnswer::SOURCE_PHOTO => 'Dari analisis foto AI',
        \App\Models\ConsultationAnswer::SOURCE_USER => 'Jawaban Anda',
    ];
    $progress = ($askedCount) / max(1, $askedCount + $remainingCount + 1) * 100;
@endphp
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <p class="text-xs font-semibold text-fm-primary uppercase tracking-wider mb-1">Langkah 2 dari 3</p>
        <h1 class="text-2xl font-bold text-gray-900">{{ $isEditing ? 'Ubah Jawaban' : 'Beberapa Pertanyaan Singkat' }}</h1>
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-fm-muted">
            <span>Perangkat terdeteksi: <strong class="text-gray-900">{{ $consultation->device->name }}</strong></span>
            <span class="text-gray-300" aria-hidden="true">|</span>
            <span>Kode {{ $consultation->consultation_code }}</span>
            <a href="{{ route('diagnosis.create') }}" class="font-semibold text-fm-primary hover:underline">Bukan perangkat ini? Ulangi</a>
        </div>
    </div>

    {{-- Progress --}}
    <div class="mb-4">
        <div class="flex items-center justify-between text-xs font-medium text-fm-muted mb-1.5">
            <span>
                @if($isEditing)
                    Mengubah jawaban sebelumnya
                @else
                    Pertanyaan ke-{{ $askedCount + 1 }}
                @endif
            </span>
            <span>
                @if($remainingCount > 0)
                    Paling banyak {{ $remainingCount }} pertanyaan lagi
                @else
                    Pertanyaan terakhir
                @endif
            </span>
        </div>
        <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-fm-primary rounded-full transition-all duration-500" style="width: {{ round($progress) }}%"></div>
        </div>
    </div>

    {{-- Current question --}}
    <form action="{{ route('diagnosis.answers', $consultation) }}" method="POST"
        x-data="{ submitting: false }" @submit="submitting = true" @pageshow.window="submitting = false"
        class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">
        @csrf
        <input type="hidden" name="symptom_id" value="{{ $question->id }}">

        <p class="text-lg sm:text-xl font-semibold text-gray-900 leading-snug">{{ $question->question }}</p>
        @if($question->description)
            <p class="text-sm text-fm-muted mt-2">{{ $question->description }}</p>
        @endif

        <div class="grid grid-cols-2 gap-3 mt-6">
            <button type="submit" name="answer" value="1" :class="submitting && 'opacity-60 pointer-events-none'"
                class="flex items-center justify-center gap-2 py-3.5 rounded-xl border text-sm font-semibold transition
                    {{ $currentAnswer === true ? 'border-fm-primary bg-fm-primary text-white' : 'border-gray-300 text-gray-700 hover:border-fm-primary hover:bg-fm-primary hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Ya
            </button>
            <button type="submit" name="answer" value="0" :class="submitting && 'opacity-60 pointer-events-none'"
                class="flex items-center justify-center gap-2 py-3.5 rounded-xl border text-sm font-semibold transition
                    {{ $currentAnswer === false ? 'border-fm-dark bg-fm-dark text-white' : 'border-gray-300 text-gray-700 hover:border-fm-dark hover:bg-fm-dark hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Tidak
            </button>
        </div>

        <p class="text-xs text-fm-muted mt-4 text-center">
            Jika ragu, pilih "Tidak". Sistem hanya menanyakan hal yang dibutuhkan untuk menentukan kerusakan.
        </p>
    </form>

    {{-- What the system already knows --}}
    @if($knownAnswers->isNotEmpty())
    <div class="mt-6 bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <div class="px-5 py-3.5 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Yang sudah kami ketahui</h2>
            <p class="text-xs text-fm-muted mt-0.5">Periksa kembali. Jawaban yang terdeteksi otomatis bisa Anda ubah.</p>
        </div>
        <ul class="divide-y divide-gray-100">
            @foreach($knownAnswers as $known)
                @continue($isEditing && $known->symptom_id === $question->id)
                <li class="flex items-start gap-3 px-5 py-3">
                    <span class="mt-0.5 text-[11px] font-bold px-2 py-0.5 rounded-md shrink-0 {{ $known->answer ? 'bg-fm-primary/10 text-fm-primary-dark' : 'bg-gray-100 text-gray-600' }}">
                        {{ $known->answer ? 'YA' : 'TIDAK' }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800">{{ $known->symptom?->question }}</p>
                        <p class="text-xs text-fm-muted mt-0.5">{{ $sourceLabels[$known->source] ?? 'Jawaban Anda' }}</p>
                    </div>
                    <a href="{{ route('diagnosis.questions', ['consultation' => $consultation, 'ubah' => $known->symptom_id]) }}"
                        class="text-xs font-semibold text-fm-primary hover:underline shrink-0 mt-0.5">Ubah</a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
