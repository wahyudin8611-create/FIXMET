@extends('layouts.app')
@section('title', 'Pesan')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Pesan</h1>

    @if($bookings->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <x-icon name="chat" class="w-10 h-10 mx-auto mb-3 text-gray-300" />
        <h3 class="font-semibold text-gray-900 mb-1">Belum Ada Pesan</h3>
        <p class="text-gray-500 text-sm">Pesan akan muncul saat Anda memiliki booking aktif</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($bookings as $booking)
        <a href="{{ route('user.bookings.show', $booking->id) }}"
            class="flex items-center gap-4 bg-white border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-colors">
            <img src="{{ $booking->technician->user->profile_photo_url }}" class="w-12 h-12 rounded-full" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-900">{{ $booking->technician->user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $booking->messages->last()?->created_at?->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-500 truncate">{{ $booking->messages->last()?->message ?? 'Belum ada pesan' }}</p>
                <span class="text-xs text-gray-400">Booking: {{ $booking->booking_code }}</span>
            </div>
            @if($booking->unread_count ?? 0)
            <span class="bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $booking->unread_count }}</span>
            @endif
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection
