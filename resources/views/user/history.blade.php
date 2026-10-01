@extends('layouts.app')
@section('title', 'Riwayat Konsultasi')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('user.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Konsultasi</h1>
            </div>
            <p class="text-gray-500 text-sm">Semua diagnosis dan konsultasi yang pernah Anda lakukan</p>
        </div>
        <a href="{{ route('user.diagnosis.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Diagnosa Baru
        </a>
    </div>

    @if($consultations->isEmpty())
    {{-- Empty state --}}
    <div class="text-center py-20">
        <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center mb-5"
             style="background: linear-gradient(135deg, #eff6ff, #f5f3ff);">
            <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada riwayat konsultasi</h3>
        <p class="text-gray-500 text-sm mb-6 max-w-xs mx-auto">Mulai diagnosis perangkat Anda dan semua riwayat akan tersimpan di sini.</p>
        <a href="{{ route('user.diagnosis.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white rounded-xl"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
            Mulai Diagnosis Pertama
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    @else

    {{-- Stats bar --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        @php
            $total = $consultations->total();
            $withDiag = $consultations->getCollection()->filter(fn($c) => $c->diagnosis_id)->count();
        @endphp
        @foreach([
            ['Total Konsultasi', $total, 'blue'],
            ['Terdiagnosis', $consultations->getCollection()->filter(fn($c) => $c->diagnosis_id)->count(), 'emerald'],
            ['Dibooking', $consultations->getCollection()->filter(fn($c) => $c->booking)->count(), 'violet'],
        ] as [$label, $count, $color])
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-extrabold text-{{ $color }}-600">{{ $count }}</p>
            <p class="text-xs text-gray-500 mt-0.5 font-medium">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    {{-- List --}}
    <div class="space-y-3">
        @foreach($consultations as $consultation)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition-all duration-200 overflow-hidden group">
            <div class="p-5 flex items-start gap-4">
                {{-- Device icon --}}
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform"
                     style="background: linear-gradient(135deg, #eff6ff, #f5f3ff);">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <div>
                            <p class="font-bold text-gray-900 text-sm">
                                {{ $consultation->device?->name ?? 'Perangkat tidak diketahui' }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $consultation->created_at->diffForHumans() }} ·
                                {{ $consultation->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- Status badge --}}
                        @php
                            $statusMap = [
                                'pending'    => ['label' => 'Menunggu', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                'processing' => ['label' => 'Diproses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                'completed'  => ['label' => 'Selesai', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
                                'failed'     => ['label' => 'Gagal', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                            ];
                            $s = $statusMap[$consultation->status] ?? ['label' => $consultation->status, 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full flex-shrink-0 {{ $s['bg'] }} {{ $s['text'] }}">
                            {{ $s['label'] }}
                        </span>
                    </div>

                    {{-- Diagnosis result --}}
                    @if($consultation->diagnosis)
                    <div class="mt-2 p-2.5 rounded-xl" style="background: #f8faff; border: 1px solid #e0eaff;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-blue-800">{{ $consultation->diagnosis->name }}</p>
                                @if($consultation->confidence)
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex-1 h-1.5 bg-blue-100 rounded-full overflow-hidden max-w-20">
                                        <div class="h-full rounded-full transition-all"
                                             style="width: {{ round($consultation->confidence * 100) }}%; background: linear-gradient(90deg, #2563eb, #7c3aed);">
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-blue-700">{{ round($consultation->confidence * 100) }}%</span>
                                </div>
                                @endif
                            </div>
                            @php
                                $sevColor = match($consultation->diagnosis->severity ?? '') {
                                    'critical' => 'bg-red-100 text-red-700',
                                    'high'     => 'bg-orange-100 text-orange-700',
                                    'medium'   => 'bg-yellow-100 text-yellow-700',
                                    default    => 'bg-emerald-100 text-emerald-700',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full capitalize {{ $sevColor }}">
                                {{ $consultation->diagnosis->severity ?? 'low' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 mt-3">
                        <a href="{{ route('user.diagnosis.show', $consultation) }}"
                           class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            Lihat Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if($consultation->booking)
                        <span class="text-gray-200">|</span>
                        <a href="{{ route('user.bookings.show', $consultation->booking) }}"
                           class="inline-flex items-center gap-1 text-xs font-semibold text-violet-600 hover:text-violet-700 transition-colors">
                            Lihat Booking
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($consultations->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $consultations->links() }}
    </div>
    @endif

    @endif
</div>
@endsection
