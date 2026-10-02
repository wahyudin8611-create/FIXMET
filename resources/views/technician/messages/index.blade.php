@extends('layouts.technician')
@section('title', 'Pesan')
@section('page-title', 'Pesan')
@section('content')
@if($bookings->isEmpty())
<div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
    <x-icon name="chat" class="w-10 h-10 mx-auto mb-3 text-gray-300" />
    <h3 class="font-semibold text-gray-900 mb-1">Belum Ada Pesan</h3>
    <p class="text-gray-500 text-sm">Pesan akan muncul setelah Anda menerima booking</p>
</div>
@else
<div class="space-y-3">
    @foreach($bookings as $booking)
    <a href="{{ route('technician.bookings.show', $booking->id) }}"
        class="flex items-center gap-4 bg-white border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-colors">
        <img src="{{ $booking->user->profile_photo_url }}" class="w-12 h-12 rounded-full" alt="">
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
                <span class="font-semibold text-gray-900">{{ $booking->user->name }}</span>
                <span class="text-xs text-gray-400">{{ $booking->messages->last()?->created_at?->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-gray-500 truncate">{{ $booking->messages->last()?->message ?? 'Belum ada pesan' }}</p>
            <span class="text-xs text-gray-400">{{ $booking->booking_code }}</span>
        </div>
    </a>
    @endforeach
</div>
@endif
@endsection
