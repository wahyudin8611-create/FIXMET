@extends('layouts.app')
@section('title', 'Daftar Teknisi')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Teknisi Terverifikasi</h1>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($technicians as $t)
        <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ $t->user->profile_photo_url }}" class="w-12 h-12 rounded-full object-cover" alt="">
                <div>
                    <div class="font-semibold text-gray-900">{{ $t->user->name }}</div>
                    <div class="flex items-center gap-1 text-sm">
                        <x-icon name="star" class="w-4 h-4 text-amber-400" />
                        <span class="text-gray-600">{{ number_format($t->rating, 1) }}</span>
                        @if($t->is_verified)
                        <span class="ml-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium inline-flex items-center gap-1"><x-icon name="shield-check" class="w-3.5 h-3.5" /> Terverifikasi</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-1"><x-icon name="wrench" class="w-4 h-4 text-gray-400 shrink-0" /> {{ $t->specialization }}</div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-1"><x-icon name="map-pin" class="w-4 h-4 text-gray-400 shrink-0" /> {{ $t->service_area }}</div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-1"><x-icon name="briefcase" class="w-4 h-4 text-gray-400 shrink-0" /> {{ $t->experience_years }} tahun pengalaman</div>
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3"><x-icon name="check-circle" class="w-4 h-4 text-gray-400 shrink-0" /> {{ $t->completed_jobs }} pekerjaan selesai</div>
            <div class="flex items-center justify-between">
                <span class="text-primary-600 font-semibold">Rp{{ number_format($t->service_fee, 0, ',', '.') }}</span>
                <a href="{{ route('technicians.show', $t) }}" class="bg-primary-600 text-white text-sm px-4 py-1.5 rounded-lg hover:bg-primary-700">Lihat</a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-10 text-gray-500">Belum ada teknisi tersedia.</div>
        @endforelse
    </div>
</div>
@endsection
