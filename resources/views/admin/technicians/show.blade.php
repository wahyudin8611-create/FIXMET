@extends('layouts.admin')
@section('title', 'Detail Teknisi')
@section('page-title', 'Detail Teknisi')
@section('content')
<div class="max-w-3xl space-y-5">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="flex items-center gap-4 mb-4">
            <img src="{{ $technician->user->profile_photo_url }}" class="w-14 h-14 rounded-full" alt="">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $technician->user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $technician->user->email }}</p>
                <span class="mt-1 inline-block px-2 py-0.5 rounded-full text-xs font-medium
                    {{ $technician->status === 'verified' ? 'bg-green-100 text-green-700' :
                       ($technician->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ ucfirst($technician->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Spesialisasi:</span><br><strong>{{ $technician->specialization }}</strong></div>
            <div><span class="text-gray-500">Area Layanan:</span><br><strong>{{ $technician->service_area }}</strong></div>
            <div><span class="text-gray-500">Pengalaman:</span><br><strong>{{ $technician->experience_years }} tahun</strong></div>
            <div><span class="text-gray-500">Biaya:</span><br><strong>Rp {{ number_format($technician->service_fee, 0, ',', '.') }}</strong></div>
            <div><span class="text-gray-500">Rating:</span><br><strong>⭐ {{ number_format($technician->rating, 1) }}</strong></div>
            <div><span class="text-gray-500">Job Selesai:</span><br><strong>{{ $technician->completed_jobs }}</strong></div>
        </div>

        @if($technician->description)
        <div class="mt-3 text-sm text-gray-600 bg-gray-50 rounded-lg p-3">{{ $technician->description }}</div>
        @endif
    </div>

    {{-- Documents --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <h3 class="font-semibold mb-3">Dokumen Verifikasi</h3>
        <div class="grid grid-cols-3 gap-3 text-sm">
            @foreach(['identity_card' => 'KTP', 'certificate' => 'Sertifikat', 'skill_evidence' => 'Bukti Keahlian'] as $field => $label)
            <div>
                <div class="text-gray-500 text-xs mb-1">{{ $label }}</div>
                @if($technician->$field)
                <a href="{{ asset('storage/' . $technician->$field) }}" target="_blank" class="text-primary-600 text-xs underline">Lihat Dokumen</a>
                @else
                <span class="text-gray-400 text-xs">Belum ada</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
        @if($technician->status === 'pending')
        <form action="{{ route('admin.technicians.verify', $technician->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-green-700">Verifikasi</button>
        </form>
        <form action="{{ route('admin.technicians.reject', $technician->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-red-100 text-red-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-red-200">Tolak</button>
        </form>
        @elseif($technician->status === 'verified')
        <form action="{{ route('admin.technicians.suspend', $technician->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-red-100 text-red-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-red-200">Suspend</button>
        </form>
        @elseif($technician->status === 'suspended')
        <form action="{{ route('admin.technicians.verify', $technician->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-green-700">Aktifkan Kembali</button>
        </form>
        @endif
        <a href="{{ route('admin.technicians.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Kembali</a>
    </div>
</div>
@endsection
