@extends('layouts.app')
@section('title', $technician->user->name)
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('user.technicians.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">&larr; Kembali</a>

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <div class="p-6 border-b">
            <div class="flex items-start gap-4">
                <img src="{{ $technician->user->profile_photo_url }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200" alt="">
                <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl font-bold text-gray-900">{{ $technician->user->name }}</h1>
                        @if($technician->is_verified)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">✓ Terverifikasi</span>
                        @endif
                        <span class="text-xs {{ $technician->is_available ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} px-2 py-0.5 rounded-full">
                            {{ $technician->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">{{ number_format($technician->rating, 1) }}</span>
                        <span class="text-gray-500 text-sm">({{ $technician->reviews->count() }} ulasan)</span>
                    </div>
                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                        <div>🔧 {{ $technician->specialization }}</div>
                        <div>📍 {{ $technician->service_area }}</div>
                        <div>💼 {{ $technician->experience_years }} tahun · ✅ {{ $technician->completed_jobs }} selesai</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-primary-600">Rp{{ number_format($technician->service_fee, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-500">Biaya awal</div>
                </div>
            </div>

            @if($technician->description)
            <p class="text-sm text-gray-600 mt-4 bg-gray-50 p-3 rounded-lg">{{ $technician->description }}</p>
            @endif

            @auth
                @if(auth()->user()->isUser() && $technician->is_available)
                <a href="{{ route('user.bookings.create', ['technician_id' => $technician->id]) }}"
                    class="mt-4 inline-block bg-primary-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-primary-700">
                    Book Teknisi
                </a>
                @endif
            @endauth
        </div>

        {{-- Reviews --}}
        @if($technician->reviews->isNotEmpty())
        <div class="p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Ulasan ({{ $technician->reviews->count() }})</h3>
            <div class="space-y-3">
                @foreach($technician->reviews->take(5) as $r)
                <div class="border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <img src="{{ $r->user->profile_photo_url }}" class="w-7 h-7 rounded-full" alt="">
                        <span class="font-medium text-sm text-gray-900">{{ $r->user->name }}</span>
                        <span class="text-yellow-500 text-sm">{{ str_repeat('⭐', $r->rating) }}</span>
                    </div>
                    @if($r->review)
                    <p class="text-sm text-gray-600">{{ $r->review }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
