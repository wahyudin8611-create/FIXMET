@extends('layouts.technician')
@section('title', 'Dashboard Teknisi')
@section('page-title', 'Dashboard Teknisi')
@section('content')

@if($technician->status === 'pending')
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
    <p class="text-yellow-700 font-medium">⏳ Profil Anda sedang menunggu verifikasi admin.</p>
</div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Permintaan Baru', $stats['pending'], 'bg-yellow-50 text-yellow-700'],
        ['Sedang Dikerjakan', $stats['in_progress'], 'bg-blue-50 text-blue-700'],
        ['Selesai', $stats['completed'], 'bg-green-50 text-green-700'],
        ['Rating', number_format($stats['rating'], 1) . ' ⭐', 'bg-purple-50 text-purple-700'],
    ] as [$label, $value, $color])
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <div class="text-2xl font-bold text-gray-900 {{ $color }} px-2 py-1 rounded-lg w-fit mb-1">{{ $value }}</div>
        <div class="text-sm text-gray-500">{{ $label }}</div>
    </div>
    @endforeach
</div>

<div class="bg-white border border-gray-200 rounded-xl">
    <div class="p-4 border-b font-semibold text-gray-900">Booking Terbaru</div>
    <div class="divide-y">
        @forelse($bookings as $b)
        <a href="{{ route('technician.bookings.show', $b->id) }}" class="flex items-center gap-3 p-4 hover:bg-gray-50">
            <img src="{{ $b->user->profile_photo_url }}" class="w-9 h-9 rounded-full" alt="">
            <div class="flex-1 min-w-0">
                <div class="font-medium text-sm text-gray-900">{{ $b->user->name }}</div>
                <div class="text-xs text-gray-500">{{ $b->consultation?->device->name ?? $b->problem_description }}</div>
                <div class="text-xs text-gray-400">{{ $b->service_date?->format('d M Y') }}</div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full bg-{{ $b->status_color }}-100 text-{{ $b->status_color }}-700">{{ $b->status_label }}</span>
        </a>
        @empty
        <div class="p-8 text-center text-gray-400 text-sm">Belum ada booking</div>
        @endforelse
    </div>
</div>
@endsection
