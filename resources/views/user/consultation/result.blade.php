@extends('layouts.app')
@section('title', 'Hasil Diagnosis')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="mb-4">
        <a href="{{ route('user.dashboard') }}" class="text-sm text-gray-500 hover:text-primary-600">&larr; Dashboard</a>
    </div>

    @if($consultation->isGuest() && auth()->guest())
    <div class="bg-white border border-fm-primary/20 rounded-2xl p-4 mb-5 flex items-start gap-3">
        <div class="w-9 h-9 rounded-xl bg-fm-primary/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="text-sm">
            <p class="font-semibold text-gray-900">Hasil ini disimpan selama {{ \App\Models\Consultation::GUEST_RETENTION_DAYS }} hari</p>
            <p class="text-fm-muted mt-0.5">
                Simpan link halaman ini untuk membukanya lagi. Agar tersimpan permanen,
                <a href="{{ route('login') }}" class="font-semibold text-fm-primary hover:underline">masuk</a> atau
                <a href="{{ route('register') }}" class="font-semibold text-fm-primary hover:underline">daftar</a>
                di browser ini, dan hasil diagnosis akan otomatis pindah ke akun Anda.
            </p>
        </div>
    </div>
    @endif

    @if($consultation->status === 'no_diagnosis')
        {{-- No Diagnosis --}}
        <div class="bg-orange-50 border border-orange-200 rounded-2xl p-8 text-center">
            <x-icon name="question" class="w-12 h-12 mx-auto mb-4 text-orange-400" />
            <h2 class="text-xl font-bold text-orange-800 mb-2">Diagnosis Tidak Dapat Ditentukan</h2>
            <p class="text-orange-700 text-sm mb-4">Tingkat kecocokan gejala dengan knowledge base kurang dari 40%. Sistem tidak dapat memberikan diagnosis yang akurat.</p>
            <div class="text-left bg-white border border-orange-200 rounded-xl p-4 max-w-sm mx-auto mb-6">
                <p class="text-sm font-medium text-gray-700 mb-2">Saran:</p>
                <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                    <li>Upload foto yang lebih jelas dengan pencahayaan baik</li>
                    <li>Tambahkan informasi gejala yang lebih detail</li>
                    <li>Konsultasikan langsung dengan teknisi</li>
                </ul>
            </div>
            <a href="{{ route('technicians.index') }}" class="inline-block bg-orange-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-orange-700">Cari Teknisi</a>
        </div>

        <div class="mt-5">
            @include('user.consultation.partials.visual-evidence')
        </div>
    @elseif($consultation->diagnosis)
        @php
            $d = $consultation->diagnosis;
            $primaryScore = collect($consultation->all_diagnoses ?? [])->firstWhere('diagnosis_id', $d->id);
        @endphp

        {{-- Main Result Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-5">
            <div class="bg-gradient-to-r from-fm-primary to-fm-primary-dark text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-200 text-sm font-medium uppercase tracking-wide">Hasil Diagnosis</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $d->name }}</h2>
                        <p class="text-emerald-200 text-sm mt-1">{{ $consultation->device->name }} — {{ $consultation->consultation_code }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ number_format($consultation->confidence, 0) }}%</div>
                        <div class="text-emerald-200 text-xs">Tingkat kecocokan</div>
                        @if(isset($primaryScore['base_confidence']) && round($primaryScore['base_confidence']) != round($consultation->confidence))
                            <div class="text-emerald-100 text-xs mt-1">
                                {{ number_format($primaryScore['base_confidence'], 0) }}% dari jawaban
                                &rarr; {{ number_format($consultation->confidence, 0) }}% setelah analisis foto
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-3 gap-4 mb-5">
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <div class="text-xs text-gray-500 mb-1">Severity</div>
                        <span class="text-sm font-semibold px-2 py-1 rounded-full
                            {{ $d->severity === 'low' ? 'bg-green-100 text-green-700' :
                               ($d->severity === 'medium' ? 'bg-yellow-100 text-yellow-700' :
                               ($d->severity === 'high' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $d->severity_label }}
                        </span>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <span class="text-sm font-semibold text-gray-700">{{ $d->repairability_label }}</span>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <div class="text-xs text-gray-500 mb-1">Perlu Teknisi</div>
                        <span class="text-sm font-semibold {{ $d->requires_technician ? 'text-red-600' : 'text-green-600' }}">
                            {{ $d->requires_technician ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                </div>

                @if($d->description)
                <div class="bg-gray-50 rounded-xl p-4 mb-5">
                    <p class="text-sm text-gray-700">{{ $d->description }}</p>
                </div>
                @endif

                {{-- Why section --}}
                @if($consultation->answers->isNotEmpty())
                <div class="mb-5">
                    <h3 class="font-semibold text-gray-900 mb-2">Mengapa diagnosis ini?</h3>
                    <div class="space-y-1">
                        @foreach($consultation->answers->where('answer', true) as $ans)
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $ans->symptom->name }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Solutions --}}
                @if($d->solutions->isNotEmpty())
                <div class="mb-5">
                    <h3 class="font-semibold text-gray-900 mb-2">Rekomendasi Tindakan</h3>
                    @foreach($d->solutions as $sol)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800">{{ $sol->solution }}</div>
                    @endforeach
                </div>
                @endif

                {{-- Safety Warning --}}
                @if(in_array($d->severity, ['high', 'critical']))
                <div class="bg-red-50 border border-red-300 rounded-xl p-4 mb-5">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="font-semibold text-red-700">Peringatan Keselamatan</p>
                            <p class="text-red-600 text-sm mt-1">Kerusakan ini membutuhkan pemeriksaan teknisi. Jangan mencoba membongkar perangkat sendiri.</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="grid grid-cols-2 gap-3 pt-2">
                    @if($repairability && $repairability['can_self_repair'] && $d->repairGuides->isNotEmpty())
                        <a href="{{ route('repair-guides.show', $d->repairGuides->first()) }}"
                            class="flex items-center justify-center gap-2 bg-fm-primary text-white py-3 rounded-xl font-semibold hover:bg-fm-primary-dark text-sm">
                            <x-icon name="book-open" class="w-4 h-4" /> Lihat Panduan Repair
                        </a>
                    @else
                        <div class="flex items-center justify-center gap-2 bg-gray-100 text-gray-400 py-3 rounded-xl font-semibold text-sm cursor-not-allowed">
                            <x-icon name="book-open" class="w-4 h-4" /> Panduan Repair
                        </div>
                    @endif
                    <a href="{{ route('technicians.index') }}" class="flex items-center justify-center gap-2 border-2 border-fm-primary text-fm-primary py-3 rounded-xl font-semibold hover:bg-fm-primary/5 text-sm">
                        <x-icon name="wrench" class="w-4 h-4" /> Cari Teknisi
                    </a>
                </div>
            </div>
        </div>

        @include('user.consultation.partials.visual-evidence')

        {{-- Foto Kerusakan --}}
        @if($consultation->images->isNotEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-5">
            <h3 class="font-semibold mb-3">Foto Kerusakan</h3>
            <div class="grid grid-cols-3 gap-3">
                @foreach($consultation->images as $img)
                <img src="{{ $img->url }}" class="w-full h-28 object-cover rounded-lg border border-gray-200" alt="Foto kerusakan">
                @endforeach
            </div>
        </div>
        @endif

        {{-- All Possible Diagnoses --}}
        @if($consultation->all_diagnoses && count($consultation->all_diagnoses) > 1)
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold mb-3">Kemungkinan Diagnosis Lainnya</h3>
            <div class="space-y-2">
                @foreach($consultation->all_diagnoses as $i => $altD)
                <div class="flex items-center justify-between py-2 {{ $i < count($consultation->all_diagnoses)-1 ? 'border-b border-gray-100' : '' }}">
                    <span class="text-sm text-gray-700">{{ $altD['name'] }}</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 bg-gray-200 rounded-full h-1.5">
                            <div class="bg-fm-primary h-1.5 rounded-full" style="width: {{ $altD['confidence'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-600 w-10 text-right">{{ number_format($altD['confidence'], 0) }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
