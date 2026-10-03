@extends('layouts.technician')
@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('content')
<div class="grid md:grid-cols-3 gap-5">
    <div class="md:col-span-2 space-y-5">
        {{-- Booking Info --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-900">{{ $booking->booking_code }}</h2>
                <span class="px-3 py-1 rounded-full text-sm bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-700 font-medium">{{ $booking->status_label }}</span>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div><span class="text-gray-500">Pengguna:</span><br><span class="font-medium">{{ $booking->user->name }}</span></div>
                <div><span class="text-gray-500">Tanggal:</span><br><span class="font-medium">{{ $booking->service_date?->format('d M Y') }} {{ $booking->service_time }}</span></div>
                <div class="col-span-2"><span class="text-gray-500">Alamat:</span><br><span class="font-medium">{{ $booking->service_address }}</span></div>
                <div class="col-span-2"><span class="text-gray-500">Masalah:</span><br><span class="font-medium">{{ $booking->problem_description }}</span></div>
            </div>

            {{-- Status Actions --}}
            <div class="flex gap-2 mt-4 flex-wrap">
                @if($booking->status === 'accepted')
                <form action="{{ route('technician.bookings.start', $booking->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-fm-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-fm-primary-dark">Mulai Kerjakan</button>
                </form>
                @elseif($booking->status === 'in_progress')
                <a href="{{ route('technician.repair-reports.create', $booking->id) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
                    Buat Laporan & Selesaikan
                </a>
                @endif
            </div>
        </div>

        {{-- Diagnosis Info --}}
        @if($booking->consultation)
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Informasi Diagnosis</h3>
            <div class="text-sm space-y-2">
                <div><span class="text-gray-500">Perangkat:</span> <span class="font-medium">{{ $booking->consultation->device->name }}</span></div>
                <div><span class="text-gray-500">Diagnosis:</span> <span class="font-medium">{{ $booking->consultation->diagnosis?->name ?? 'Belum ada' }}</span></div>
                @if($booking->consultation->confidence)
                <div><span class="text-gray-500">Confidence:</span> <span class="font-medium">{{ number_format($booking->consultation->confidence, 0) }}%</span></div>
                @endif
            </div>
            @if($booking->consultation->images->isNotEmpty())
            <div class="mt-3">
                <p class="text-xs text-gray-500 mb-2">Foto Kerusakan</p>
                <div class="flex gap-2 flex-wrap">
                    @foreach($booking->consultation->images as $img)
                    <img src="{{ $img->url }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200" alt="">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Repair Report --}}
        @if($booking->repairReport)
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Laporan Perbaikan</h3>
            <div class="text-sm space-y-2">
                <div><span class="text-gray-600">Diagnosis Aktual:</span> <span class="font-medium">{{ $booking->repairReport->actual_diagnosis }}</span></div>
                <div><span class="text-gray-600">Tindakan:</span> <span class="font-medium">{{ $booking->repairReport->repair_action }}</span></div>
                <div><span class="text-gray-600">Hasil:</span> <span class="font-medium">{{ $booking->repairReport->repair_result }}</span></div>
            </div>
        </div>
        @endif
    </div>

    {{-- Chat --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm flex flex-col"
         id="chat"
         data-booking-id="{{ $booking->id }}"
         data-me-id="{{ auth()->id() }}"
         data-list-url="{{ route('technician.messages.list', $booking->id) }}"
         data-me-avatar="{{ auth()->user()->profile_photo_url }}"
         data-partner-avatar="{{ $booking->user->profile_photo_url }}">

        {{-- Chat header: profil pengguna --}}
        <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 bg-white">
            <div class="relative shrink-0">
                <img src="{{ $booking->user->profile_photo_url }}"
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-50" alt="">
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"
                      title="Terhubung"></span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-semibold text-gray-900 text-sm leading-tight truncate">{{ $booking->user->name }}</div>
                <div class="text-xs text-gray-500 truncate">Pengguna · {{ $booking->booking_code }}</div>
            </div>
            <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Live
            </span>
        </div>

        {{-- Messages --}}
        <div class="h-80 md:h-96 overflow-y-auto px-4 py-4 space-y-1 bg-gray-50" id="chatBox"
             style="background-image: radial-gradient(rgba(61,139,122,0.05) 1px, transparent 1px); background-size: 18px 18px;">
            <div class="text-center text-xs text-gray-400 py-8" id="chatLoading">Memuat percakapan…</div>
        </div>

        {{-- Composer --}}
        <form id="chatForm" action="{{ route('technician.messages.send', $booking->id) }}" method="POST"
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
</div>

@push('scripts')
@include('partials.chat-live')
@endpush
@endsection
