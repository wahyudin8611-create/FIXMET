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
            class="flex items-center gap-4 border rounded-xl p-4 transition-colors {{ $booking->unread_count ? 'bg-fm-primary/5 border-fm-primary/30 hover:bg-fm-primary/10' : 'bg-white border-gray-200 hover:bg-gray-50' }}">
            <img src="{{ $booking->technician->user->profile_photo_url }}" class="w-12 h-12 rounded-full" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-gray-900 {{ $booking->unread_count ? 'font-bold' : 'font-semibold' }}">{{ $booking->technician->user->name }}</span>
                    <span class="flex items-center gap-2 shrink-0">
                        <span class="text-xs {{ $booking->unread_count ? 'text-fm-primary font-semibold' : 'text-gray-400' }}">{{ $booking->messages->last()?->created_at?->diffForHumans() }}</span>
                        @if($booking->unread_count)
                        <span class="inline-flex min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[11px] font-bold leading-none items-center justify-center" aria-label="{{ $booking->unread_count }} pesan belum dibaca">{{ $booking->unread_count }}</span>
                        @endif
                    </span>
                </div>
                <p class="text-sm truncate {{ $booking->unread_count ? 'text-gray-900 font-medium' : 'text-gray-500' }}">{{ $booking->messages->last()?->message ?? 'Belum ada pesan' }}</p>
                <span class="text-xs text-gray-400">Booking: {{ $booking->booking_code }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection
