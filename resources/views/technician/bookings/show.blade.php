@extends('layouts.technician')
@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
@section('content')
<div class="grid lg:grid-cols-3 gap-5 items-start">
    <div class="{{ $booking->chatIsOpen() ? 'lg:col-span-2' : 'lg:col-span-3' }} space-y-5">
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
    @if($booking->chatIsOpen())
    <x-booking-chat class="lg:sticky lg:top-6"
        :booking="$booking"
        :partner="$booking->user"
        partner-role="Pengguna"
        :list-url="route('technician.messages.list', $booking->id)"
        :send-url="route('technician.messages.send', $booking->id)" />
    @endif
</div>
@endsection
