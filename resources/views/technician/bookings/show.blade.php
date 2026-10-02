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
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden flex flex-col h-96 md:h-auto">
        <div class="p-3 border-b font-semibold text-gray-900 text-sm"><x-icon name="chat" class="inline w-4 h-4 mr-1 align-text-bottom" />Chat</div>
        <div class="flex-1 overflow-y-auto p-3 space-y-2 bg-gray-50" id="chatBox">
            @foreach($booking->messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-3 py-2 rounded-xl text-sm {{ $msg->sender_id === auth()->id() ? 'bg-primary-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }}">
                    {{ $msg->message }}
                    <div class="text-xs opacity-60 mt-0.5">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <form action="{{ route('technician.messages.send', $booking->id) }}" method="POST" class="p-2 border-t flex gap-2">
            @csrf
            <input type="text" name="message" placeholder="Pesan..." required class="flex-1 border border-gray-300 rounded-lg px-2 py-1.5 text-sm">
            <button type="submit" class="bg-primary-600 text-white px-3 py-1.5 rounded-lg text-sm">Kirim</button>
        </form>
    </div>
</div>

@push('scripts')
<script>const c=document.getElementById('chatBox'); if(c) c.scrollTop=c.scrollHeight;</script>
@endpush
@endsection
