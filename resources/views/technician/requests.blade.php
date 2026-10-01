@extends('layouts.technician')
@section('title', 'Permintaan Baru')
@section('page-title', 'Permintaan Masuk')
@section('content')
<div class="space-y-4">
    @forelse($bookings as $b)
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ $b->user->profile_photo_url }}" class="w-10 h-10 rounded-full" alt="">
                <div>
                    <div class="font-semibold text-gray-900">{{ $b->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $b->service_date?->format('d M Y') }} · {{ $b->booking_code }}</div>
                </div>
            </div>
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">Menunggu</span>
        </div>

        <div class="mt-3 text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
            {{ $b->problem_description }}
        </div>

        @if($b->consultation)
        <div class="mt-2 text-xs text-blue-700 bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
            📋 Diagnosis: <strong>{{ $b->consultation->diagnosis?->name ?? 'Belum ada diagnosis' }}</strong>
            ({{ $b->consultation->device->name }})
        </div>
        @endif

        @if($b->consultation && $b->consultation->images->isNotEmpty())
        <div class="flex gap-2 mt-2">
            @foreach($b->consultation->images->take(3) as $img)
            <img src="{{ $img->url }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200" alt="">
            @endforeach
        </div>
        @endif

        <div class="flex gap-2 mt-4">
            <form action="{{ route('technician.bookings.accept', $b->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">✓ Terima</button>
            </form>
            <button onclick="document.getElementById('reject-{{ $b->id }}').classList.toggle('hidden')"
                class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100">✗ Tolak</button>
            <a href="{{ route('technician.bookings.show', $b->id) }}" class="border border-gray-200 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Detail</a>
        </div>

        <div id="reject-{{ $b->id }}" class="hidden mt-3">
            <form action="{{ route('technician.bookings.reject', $b->id) }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="reason" rows="2" placeholder="Alasan penolakan..." required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-2"></textarea>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Konfirmasi Tolak</button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white border border-gray-200 rounded-xl p-10 text-center">
        <div class="text-4xl mb-3">📥</div>
        <p class="text-gray-500">Tidak ada permintaan baru</p>
    </div>
    @endforelse
</div>
@endsection
