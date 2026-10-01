@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')
@section('content')

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    @foreach([
        ['Total Users', $stats['total_users'], '👥', 'blue'],
        ['Teknisi Aktif', $stats['total_technicians'], '🔧', 'green'],
        ['Menunggu Verifikasi', $stats['pending_technicians'], '⏳', 'yellow'],
        ['Total Konsultasi', $stats['total_consultations'], '🔍', 'purple'],
        ['Total Booking', $stats['total_bookings'], '📅', 'indigo'],
        ['Perbaikan Selesai', $stats['completed_bookings'], '✅', 'green'],
    ] as [$label, $value, $icon, $color])
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <div class="text-2xl mb-1">{{ $icon }}</div>
        <div class="text-2xl font-bold text-gray-900">{{ $value }}</div>
        <div class="text-sm text-gray-500">{{ $label }}</div>
    </div>
    @endforeach
</div>

<div class="grid md:grid-cols-2 gap-5">
    {{-- Pending Technicians --}}
    <div class="bg-white border border-gray-200 rounded-xl">
        <div class="flex items-center justify-between p-4 border-b">
            <h2 class="font-semibold text-gray-900">Teknisi Menunggu Verifikasi</h2>
            <a href="{{ route('admin.technicians.index') }}" class="text-sm text-primary-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse($pendingTechnicians as $t)
            <div class="flex items-center gap-3 p-4">
                <img src="{{ $t->user->profile_photo_url }}" class="w-9 h-9 rounded-full" alt="">
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm">{{ $t->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $t->specialization }} · {{ $t->service_area }}</div>
                </div>
                <div class="flex gap-1">
                    <form action="{{ route('admin.technicians.verify', $t->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">Verifikasi</button>
                    </form>
                    <a href="{{ route('admin.technicians.show', $t->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Detail</a>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-400 text-sm">Tidak ada yang menunggu verifikasi</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white border border-gray-200 rounded-xl">
        <div class="p-4 border-b">
            <h2 class="font-semibold text-gray-900">Booking Terbaru</h2>
        </div>
        <div class="divide-y">
            @forelse($recentBookings as $b)
            <div class="flex items-center gap-3 p-4">
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm">{{ $b->user->name }}</div>
                    <div class="text-xs text-gray-500">→ {{ $b->technician->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $b->created_at->diffForHumans() }}</div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full bg-{{ $b->status_color }}-100 text-{{ $b->status_color }}-700">{{ $b->status_label }}</span>
            </div>
            @empty
            <div class="p-6 text-center text-gray-400 text-sm">Belum ada booking</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
