@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ $user->name }}!</h1>
            <p class="text-gray-500 text-sm mt-1">Perangkat ada masalah? Mulai diagnosis sekarang.</p>
        </div>
        <a href="{{ route('diagnosis.create') }}" class="bg-primary-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-700 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Diagnosa Kerusakan
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['Total Diagnosis', $stats['total_diagnosis'], 'bg-blue-50 text-blue-700', 'search'],
            ['Total Perbaikan', $stats['total_repair'], 'bg-green-50 text-green-700', 'wrench'],
            ['Booking Aktif', $stats['active_booking'], 'bg-yellow-50 text-yellow-700', 'calendar'],
            ['Selesai', $stats['completed_repair'], 'bg-purple-50 text-purple-700', 'check-circle'],
        ] as [$label, $value, $color, $icon])
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-2 {{ $color }}"><x-icon :name="$icon" class="w-5 h-5" /></div>
            <div class="text-2xl font-bold text-gray-900">{{ $value }}</div>
            <div class="text-sm text-gray-500">{{ $label }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Recent Diagnoses --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="font-semibold text-gray-900">Diagnosis Terbaru</h2>
                <a href="{{ route('user.diagnosis.index') }}" class="text-sm text-primary-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y">
                @forelse($consultations as $c)
                <a href="{{ route('diagnosis.result', $c) }}" class="flex items-center gap-3 p-4 hover:bg-gray-50">
                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-700">
                        {{ strtoupper(substr($c->device->name ?? 'D', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $c->device->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $c->diagnosis?->name ?? 'Belum ada diagnosis' }}</div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $c->status === 'completed' ? 'bg-green-100 text-green-700' : ($c->status === 'no_diagnosis' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                    </span>
                </a>
                @empty
                <div class="p-6 text-center text-gray-400 text-sm">Belum ada diagnosis</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Bookings --}}
        <div class="bg-white border border-gray-200 rounded-xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="font-semibold text-gray-900">Booking Terbaru</h2>
                <a href="{{ route('user.bookings.index') }}" class="text-sm text-primary-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y">
                @forelse($bookings as $b)
                <a href="{{ route('user.bookings.show', $b->id) }}" class="flex items-center gap-3 p-4 hover:bg-gray-50">
                    <img src="{{ $b->technician->user->profile_photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $b->technician->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $b->service_date?->format('d M Y') }}</div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-{{ $b->status_color }}-100 text-{{ $b->status_color }}-700">{{ $b->status_label }}</span>
                </a>
                @empty
                <div class="p-6 text-center text-gray-400 text-sm">Belum ada booking</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
