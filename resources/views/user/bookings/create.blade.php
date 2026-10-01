@extends('layouts.app')
@section('title', 'Buat Booking')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <a href="{{ route('user.technicians.show', $technician->id) }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Buat Booking</h1>

    {{-- Technician Card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-center gap-3">
        <img src="{{ $technician->user->profile_photo_url }}" class="w-12 h-12 rounded-full" alt="">
        <div>
            <div class="font-semibold text-gray-900">{{ $technician->user->name }}</div>
            <div class="text-sm text-gray-600">{{ $technician->specialization }} · {{ $technician->service_area }}</div>
            <div class="text-sm font-semibold text-primary-600">Rp{{ number_format($technician->service_fee, 0, ',', '.') }}</div>
        </div>
    </div>

    <form action="{{ route('user.bookings.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="technician_id" value="{{ $technician->id }}">
        @if($consultation)
        <input type="hidden" name="consultation_id" value="{{ $consultation->id }}">
        @endif

        @if($consultation)
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800">
            📋 Booking ini terkait dengan diagnosis: <strong>{{ $consultation->diagnosis?->name ?? $consultation->consultation_code }}</strong>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Layanan <span class="text-red-500">*</span></label>
                <input type="date" name="service_date" min="{{ date('Y-m-d') }}" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                @error('service_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Layanan <span class="text-red-500">*</span></label>
                <input type="time" name="service_time" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                @error('service_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Layanan <span class="text-red-500">*</span></label>
            <textarea name="service_address" rows="2" required placeholder="Alamat lengkap..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">{{ old('service_address', auth()->user()->address) }}</textarea>
            @error('service_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Masalah <span class="text-red-500">*</span></label>
            <textarea name="problem_description" rows="3" required placeholder="Jelaskan masalah perangkat Anda..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">{{ old('problem_description', $consultation?->initial_complaint) }}</textarea>
            @error('problem_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold hover:bg-primary-700">Buat Booking</button>
    </form>
</div>
@endsection
