@extends('layouts.technician')
@section('title', 'Booking')
@section('page-title', 'Semua Booking')
@section('content')
<div class="bg-white border border-gray-200 rounded-xl divide-y">
    @forelse($bookings as $b)
    <a href="{{ route('technician.bookings.show', $b->id) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50">
        <img src="{{ $b->user->profile_photo_url }}" class="w-10 h-10 rounded-full" alt="">
        <div class="flex-1 min-w-0">
            <div class="font-medium text-gray-900">{{ $b->user->name }}</div>
            <div class="text-sm text-gray-500">{{ $b->consultation?->device->category->name ?? '-' }} · {{ $b->booking_code }}</div>
            <div class="text-xs text-gray-400">{{ $b->service_date?->format('d M Y') }}</div>
        </div>
        <span class="text-xs px-2 py-1 rounded-full bg-{{ $b->status_color }}-100 text-{{ $b->status_color }}-700 font-medium">{{ $b->status_label }}</span>
    </a>
    @empty
    <div class="p-10 text-center text-gray-400">Belum ada booking</div>
    @endforelse
</div>
<div class="mt-4">{{ $bookings->links() }}</div>
@endsection
