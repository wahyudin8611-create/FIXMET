{{-- Booking chat window shared by the user and technician booking pages, so both
     sides see the same design. Behaviour lives in partials.chat-live. --}}
@props([
    'booking',
    'partner',
    'partnerRole',
    'listUrl',
    'sendUrl',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm flex flex-col']) }}
     id="chat"
     data-booking-id="{{ $booking->id }}"
     data-me-id="{{ auth()->id() }}"
     data-list-url="{{ $listUrl }}"
     data-me-avatar="{{ auth()->user()->profile_photo_url }}"
     data-partner-avatar="{{ $partner->profile_photo_url }}"
     data-partner-label="{{ $partnerRole }}">

    {{-- Header: chat partner --}}
    <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 bg-white">
        <div class="relative shrink-0">
            <img src="{{ $partner->profile_photo_url }}"
                 class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-50" alt="">
            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"
                  title="Terhubung"></span>
        </div>
        <div class="min-w-0 flex-1">
            <div class="font-semibold text-gray-900 text-sm leading-tight truncate">{{ $partner->name }}</div>
            <div class="text-xs text-gray-500 truncate">{{ $partnerRole }} · {{ $booking->booking_code }}</div>
        </div>
        <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Live
        </span>
    </div>

    {{-- Messages --}}
    <div class="h-96 overflow-y-auto px-4 py-4 space-y-1 bg-gray-50" id="chatBox"
         style="background-image: radial-gradient(rgba(61,139,122,0.05) 1px, transparent 1px); background-size: 18px 18px;">
        <div class="text-center text-xs text-gray-400 py-8" id="chatLoading">Memuat percakapan…</div>
    </div>

    {{-- Composer --}}
    <form id="chatForm" action="{{ $sendUrl }}" method="POST"
          class="p-3 border-t border-gray-100 flex items-end gap-2 bg-white">
        @csrf
        <input type="text" name="message" id="chatInput" placeholder="Ketik pesan…" required maxlength="1000" autocomplete="off"
            class="flex-1 min-w-0 border border-gray-300 rounded-full px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
        <button type="submit" id="chatSend"
            class="bg-primary-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary-700 transition shrink-0 disabled:opacity-50"
            aria-label="Kirim">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>
    </form>
</div>

@pushOnce('scripts')
@include('partials.chat-live')
@endPushOnce
