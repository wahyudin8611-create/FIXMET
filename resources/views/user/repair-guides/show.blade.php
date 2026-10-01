@extends('layouts.app')
@section('title', $repairGuide->title)
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ url()->previous(route('home')) }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">&larr; Kembali</a>

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6">
            <div class="flex items-center gap-2 text-green-200 text-sm mb-2">
                <span>📖 Panduan Perbaikan</span>
            </div>
            <h1 class="text-2xl font-bold">{{ $repairGuide->title }}</h1>
            <p class="text-green-200 text-sm mt-1">{{ $repairGuide->diagnosis->name }} — {{ $repairGuide->diagnosis->device->name }}</p>
        </div>

        <div class="p-6">
            {{-- Info --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="text-center p-3 bg-gray-50 rounded-xl">
                    <div class="text-xs text-gray-500 mb-1">Kesulitan</div>
                    <span class="text-sm font-semibold text-gray-800">{{ $repairGuide->difficulty_label }}</span>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-xl">
                    <div class="text-xs text-gray-500 mb-1">Estimasi Waktu</div>
                    <span class="text-sm font-semibold text-gray-800">{{ $repairGuide->estimated_time }} menit</span>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-xl">
                    <div class="text-xs text-gray-500 mb-1">Risiko</div>
                    <span class="text-sm font-semibold text-{{ $repairGuide->risk_level === 'low' ? 'green' : ($repairGuide->risk_level === 'medium' ? 'yellow' : 'red') }}-700">{{ ucfirst($repairGuide->risk_level) }}</span>
                </div>
            </div>

            {{-- Safety Warning --}}
            @if($repairGuide->safety_warning)
            <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-4 mb-5">
                <div class="flex items-start gap-2">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <p class="font-semibold text-yellow-800">Peringatan Keselamatan</p>
                        <p class="text-yellow-700 text-sm mt-1">{{ $repairGuide->safety_warning }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tools --}}
            @if($repairGuide->required_tools)
            <div class="mb-5">
                <h3 class="font-semibold text-gray-900 mb-2">Alat yang Dibutuhkan</h3>
                <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line">{{ $repairGuide->required_tools }}</div>
            </div>
            @endif

            {{-- Steps --}}
            @if($repairGuide->steps->isNotEmpty())
            <div class="mb-5">
                <h3 class="font-semibold text-gray-900 mb-3">Langkah Perbaikan</h3>
                <div class="space-y-4">
                    @foreach($repairGuide->steps as $step)
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">{{ $step->step_number }}</div>
                        <div class="flex-1 pt-1">
                            <h4 class="font-semibold text-gray-900">{{ $step->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $step->description }}</p>
                            @if($step->warning)
                            <div class="mt-2 text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">⚠️ {{ $step->warning }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Do Not Do --}}
            @if($repairGuide->do_not_do)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <h3 class="font-semibold text-red-700 mb-2">❌ Jangan Dilakukan</h3>
                <p class="text-sm text-red-600 whitespace-pre-line">{{ $repairGuide->do_not_do }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('technicians.index') }}" class="text-sm text-primary-600 hover:underline">Butuh bantuan? Cari teknisi →</a>
    </div>
</div>
@endsection
