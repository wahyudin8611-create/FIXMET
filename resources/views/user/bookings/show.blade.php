@extends('layouts.app')
@section('title', 'Detail Booking')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('user.bookings.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">&larr; Kembali</a>

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-5">
        <div class="p-5 border-b flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-lg font-bold text-gray-900">{{ $booking->booking_code }}</h1>
                <p class="text-sm text-gray-500">{{ $booking->service_date?->format('d M Y') }} pukul {{ $booking->service_time }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-700">
                {{ $booking->status_label }}
            </span>
        </div>

        <div class="p-5 grid md:grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Teknisi</h3>
                <div class="flex items-center gap-2">
                    <img src="{{ $booking->technician->user->profile_photo_url }}" class="w-9 h-9 rounded-full" alt="">
                    <div>
                        <div class="font-medium text-sm text-gray-900">{{ $booking->technician->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->technician->specialization }}</div>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Alamat Layanan</h3>
                <p class="text-sm text-gray-600">{{ $booking->service_address }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Masalah</h3>
                <p class="text-sm text-gray-600">{{ $booking->problem_description }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Estimasi Biaya</h3>
                <p class="text-sm font-semibold text-primary-600">Rp{{ number_format($booking->estimated_fee ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($booking->status === 'pending')
        <div class="p-5 border-t">
            <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Batalkan booking ini?')">
                @csrf @method('PATCH')
                <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100">Batalkan Booking</button>
            </form>
        </div>
        @endif
    </div>

    {{-- Repair Report --}}
    @if($booking->repairReport)
    <div class="bg-white border border-gray-200 rounded-xl p-5 mb-5">
        <h2 class="font-semibold text-gray-900 mb-3">Laporan Perbaikan</h2>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Diagnosis Aktual:</span><br><span class="font-medium">{{ $booking->repairReport->actual_diagnosis }}</span></div>
            <div><span class="text-gray-500">Status Hasil:</span><br><span class="font-medium">{{ $booking->repairReport->repair_result }}</span></div>
            @if($booking->repairReport->additional_cost > 0)
            <div><span class="text-gray-500">Biaya Tambahan:</span><br><span class="font-medium text-primary-600">Rp{{ number_format($booking->repairReport->additional_cost, 0, ',', '.') }}</span></div>
            @endif
        </div>
        @if($booking->repairReport->images->isNotEmpty())
        <div class="mt-3">
            <p class="text-sm font-medium text-gray-700 mb-2">Foto Perbaikan</p>
            <div class="grid grid-cols-4 gap-2">
                @foreach($booking->repairReport->images as $img)
                <img src="{{ $img->url }}" class="w-full h-20 object-cover rounded-lg border border-gray-200" alt="{{ $img->image_type }}">
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Review --}}
    @if($booking->status === 'completed')
        @if($booking->review)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-5">
            <h2 class="font-semibold text-gray-900 mb-1">Ulasan Anda</h2>
            <div class="flex gap-0.5 text-amber-400" aria-label="{{ $booking->review->rating }} dari 5 bintang">@for($star = 1; $star <= 5; $star++)<x-icon name="star" class="w-4 h-4 {{ $star <= $booking->review->rating ? '' : 'text-gray-200' }}" />@endfor</div>
            @if($booking->review->review)
            <p class="text-sm text-gray-700 mt-1">{{ $booking->review->review }}</p>
            @endif
        </div>
        @else
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-5">
            <h2 class="font-semibold text-gray-900 mb-3">Berikan Ulasan</h2>
            <form action="{{ route('user.reviews.store', $booking->id) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating <span class="text-red-500">*</span></label>
                    <select name="rating" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} dari 5</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ulasan</label>
                    <textarea name="review" rows="2" placeholder="Ceritakan pengalaman Anda..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>
                </div>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600">Kirim Ulasan</button>
            </form>
        </div>
        @endif
    @endif

    {{-- Chat --}}
    @if(in_array($booking->status, ['accepted', 'scheduled', 'in_progress', 'completed']))
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm"
         id="chat"
         data-booking-id="{{ $booking->id }}"
         data-me-id="{{ auth()->id() }}"
         data-list-url="{{ route('user.messages.list', $booking->id) }}"
         data-me-avatar="{{ auth()->user()->profile_photo_url }}"
         data-partner-avatar="{{ $booking->technician->user->profile_photo_url }}">

        {{-- Chat header: profil teknisi --}}
        <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 bg-white">
            <div class="relative shrink-0">
                <img src="{{ $booking->technician->user->profile_photo_url }}"
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-50" alt="">
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"
                      title="Terhubung"></span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-semibold text-gray-900 text-sm leading-tight truncate">{{ $booking->technician->user->name }}</div>
                <div class="text-xs text-gray-500 truncate">{{ $booking->technician->specialization ?? 'Teknisi' }}</div>
            </div>
            <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Live
            </span>
        </div>

        {{-- Messages --}}
        <div class="h-80 overflow-y-auto px-4 py-4 space-y-1 bg-gray-50" id="chatBox"
             style="background-image: radial-gradient(rgba(61,139,122,0.05) 1px, transparent 1px); background-size: 18px 18px;">
            <div class="text-center text-xs text-gray-400 py-8" id="chatLoading">Memuat percakapan…</div>
        </div>

        {{-- Composer --}}
        <form id="chatForm" action="{{ route('user.messages.send', $booking->id) }}" method="POST"
              class="p-3 border-t border-gray-100 flex items-end gap-2 bg-white">
            @csrf
            <input type="text" name="message" id="chatInput" placeholder="Ketik pesan…" required maxlength="2000" autocomplete="off"
                class="flex-1 border border-gray-300 rounded-full px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            <button type="submit" id="chatSend"
                class="bg-primary-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary-700 transition shrink-0 disabled:opacity-50"
                aria-label="Kirim">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
        </form>
    </div>
    @endif
</div>

@push('scripts')
@include('partials.chat-live')
@endpush
@endsection
