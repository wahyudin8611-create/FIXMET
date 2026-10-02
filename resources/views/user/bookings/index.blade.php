@extends('layouts.app')
@section('title', 'Booking Saya')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Booking Saya</h1>
    <div class="bg-white border border-gray-200 rounded-xl divide-y">
        @forelse($bookings as $b)
        <a href="{{ route('user.bookings.show', $b->id) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50">
            <img src="{{ $b->technician->user->profile_photo_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900">{{ $b->technician->user->name }}</div>
                <div class="text-sm text-gray-500">{{ $b->consultation?->device->name ?? $b->problem_description }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $b->service_date?->format('d M Y') }} · {{ $b->booking_code }}</div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full bg-{{ $b->status_color }}-100 text-{{ $b->status_color }}-700 font-medium">{{ $b->status_label }}</span>
        </a>
        @empty
        <div class="p-10 text-center">
            <x-icon name="calendar" class="w-10 h-10 mx-auto mb-3 text-gray-300" />
            <p class="text-gray-500">Belum ada booking</p>
            <a href="{{ route('technicians.index') }}" class="inline-block mt-3 text-primary-600 font-medium text-sm hover:underline">Cari teknisi sekarang</a>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $bookings->links() }}</div>
</div>
@endsection
