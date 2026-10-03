@extends('layouts.app')
@section('title', 'Daftar Teknisi')
@section('content')
@php $fmt = fn ($n) => 'Rp'.number_format((float) $n, 0, ',', '.'); @endphp
<div class="max-w-5xl mx-auto px-4 py-8" x-data="{ analyze: false }">
    <h1 class="text-2xl font-bold mb-6">Teknisi Terverifikasi</h1>

    {{-- Ajakan analisis bila harga masih terkunci --}}
    @unless($estimate)
    <div class="bg-fm-primary/[.05] border border-fm-primary/15 rounded-2xl p-5 sm:p-6 mb-7 flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-fm-primary/10 flex items-center justify-center shrink-0">
            <x-icon name="wrench" class="w-6 h-6 text-fm-primary" />
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-fm-dark">Harga disesuaikan dengan kerusakan Anda</p>
            <p class="text-sm text-fm-muted">Lakukan analisis kerusakan dulu agar setiap teknisi menampilkan estimasi biaya yang sesuai.</p>
        </div>
        <button type="button" @click="analyze = true"
            class="bg-fm-primary text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-fm-primary-dark transition shrink-0">
            Analisis Kerusakan
        </button>
    </div>
    @endunless

    {{-- Estimasi biaya AI (muncul bila dibuka dari hasil diagnosis) --}}
    @if($estimate)
    @php
        $levelColor = ['ringan' => 'green', 'sedang' => 'yellow', 'berat' => 'red'][$estimate['damage_level']] ?? 'gray';
    @endphp
    <div class="bg-fm-primary/[.05] border border-fm-primary/15 rounded-2xl p-5 sm:p-6 mb-7">
        <div class="flex items-center gap-2 mb-2 flex-wrap">
            <span class="eyebrow text-fm-primary">Estimasi Biaya AI</span>
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-{{ $levelColor }}-100 text-{{ $levelColor }}-700">
                Kerusakan {{ ucfirst($estimate['damage_level']) }}
            </span>
            <span class="text-[11px] text-fm-muted">· estimasi {{ $estimate['estimated_hours'] }} jam kerja</span>
            @if($estimate['source'] === 'ai')
            <span class="text-[11px] text-fm-muted">· dianalisis otomatis oleh AI</span>
            @endif
        </div>

        <div class="text-2xl sm:text-[1.75rem] font-extrabold text-fm-dark tracking-tight mb-1" style="font-variant-numeric:tabular-nums;">
            Estimasi Kerusakan: {{ $fmt($estimate['total_min']) }} – {{ $fmt($estimate['total_max']) }}
        </div>
        <p class="text-sm text-fm-muted mb-4">
            Rincian: Jasa (acuan) {{ $fmt($estimate['hourly_reference']) }}/jam × {{ $estimate['estimated_hours'] }} jam
            + Suku Cadang {{ $fmt($estimate['parts_total_min']) }}–{{ $fmt($estimate['parts_total_max']) }}
            + Layanan Platform {{ $fmt($estimate['platform_fee']) }}
        </p>

        @if(!empty($estimate['parts']))
        <div class="bg-white/70 rounded-xl border border-black/[.04] divide-y divide-black/[.04] mb-3">
            @foreach($estimate['parts'] as $part)
            <div class="flex items-center justify-between gap-3 px-4 py-2.5 text-sm">
                <span class="text-gray-700">{{ $part['name'] }}</span>
                <span class="font-medium text-gray-900 shrink-0" style="font-variant-numeric:tabular-nums;">{{ $fmt($part['price_min']) }}–{{ $fmt($part['price_max']) }}</span>
            </div>
            @endforeach
        </div>
        @endif

        <p class="text-xs text-fm-muted">
            Estimasi otomatis berdasarkan gejala & foto kerusakan — <strong class="font-semibold">bukan harga final</strong>.
            Harga per teknisi di bawah memakai tarif jasa masing-masing.
        </p>
    </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($technicians as $t)
        @php $te = $perTechnician[$t->id] ?? null; @endphp
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

            @if($te)
            {{-- Harga estimasi dinamis berdasarkan analisis kerusakan --}}
            <div class="bg-fm-primary/[.04] border border-fm-primary/10 rounded-lg px-3 py-2.5 mb-3">
                <div class="text-[11px] text-fm-muted mb-0.5">Estimasi untuk teknisi ini</div>
                <div class="text-primary-600 font-bold" style="font-variant-numeric:tabular-nums;">{{ $fmt($te['total_min']) }} – {{ $fmt($te['total_max']) }}</div>
                <div class="text-[11px] text-gray-500 mt-0.5">
                    Jasa {{ $fmt($te['hourly']) }}/jam × {{ $te['hours'] }} jam + Sparepart {{ $fmt($te['parts_min']) }}–{{ $fmt($te['parts_max']) }} + Platform {{ $fmt($te['platform_fee']) }}
                </div>
            </div>
            <div class="flex items-center justify-end">
                <a href="{{ route('technicians.show', $t) }}" class="bg-primary-600 text-white text-sm px-4 py-1.5 rounded-lg hover:bg-primary-700">Lihat</a>
            </div>
            @else
            {{-- Harga terkunci sampai pengguna menganalisis kerusakan --}}
            <div class="flex items-center justify-between gap-2">
                <button type="button" @click="analyze = true"
                    class="flex items-center gap-1.5 text-sm font-semibold text-fm-primary hover:text-fm-primary-dark transition">
                    <x-icon name="wrench" class="w-4 h-4" /> Analisis Kerusakan Dahulu
                </button>
                <a href="{{ route('technicians.show', $t) }}" class="bg-primary-600 text-white text-sm px-4 py-1.5 rounded-lg hover:bg-primary-700">Lihat</a>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-3 text-center py-10 text-gray-500">Belum ada teknisi tersedia.</div>
        @endforelse
    </div>

    {{-- Pop-up: Analisis Kerusakan Elektronik --}}
    <div x-show="analyze" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(26,35,50,.55);"
         @keydown.escape.window="analyze = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6" @click.outside="analyze = false">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-fm-primary/10 flex items-center justify-center">
                        <x-icon name="wrench" class="w-5 h-5 text-fm-primary" />
                    </div>
                    <h2 class="font-bold text-fm-dark text-lg">Analisis Kerusakan Elektronik</h2>
                </div>
                <button type="button" @click="analyze = false" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>

            <p class="text-sm text-fm-muted mb-4">
                Agar setiap teknisi menampilkan estimasi biaya yang sesuai, AI kami perlu menganalisis kerusakan Anda. Anda akan diminta memasukkan:
            </p>
            <ul class="space-y-2 mb-5">
                @foreach(['Jenis perangkat elektronik', 'Merek & tipe', 'Deskripsi masalah/kerusakan', 'Foto/video pendukung (opsional)'] as $item)
                <li class="flex items-center gap-2 text-sm text-gray-700">
                    <x-icon name="check-circle" class="w-4 h-4 text-fm-primary shrink-0" /> {{ $item }}
                </li>
                @endforeach
            </ul>

            <div class="bg-fm-primary/[.05] rounded-lg px-3 py-2.5 mb-5 text-xs text-fm-muted">
                Hasil analisis menentukan <strong class="font-semibold">tingkat kerusakan</strong>, <strong class="font-semibold">perkiraan suku cadang</strong>, dan <strong class="font-semibold">jam kerja</strong> — lalu harga tiap teknisi dihitung otomatis.
            </div>

            <a href="{{ route('diagnosis.create') }}"
               class="block text-center bg-fm-primary text-white font-semibold px-5 py-3 rounded-xl hover:bg-fm-primary-dark transition">
                Mulai Analisis Kerusakan
            </a>
            <button type="button" @click="analyze = false" class="block w-full text-center text-sm text-fm-muted mt-3 hover:text-gray-700">
                Nanti saja
            </button>
        </div>
    </div>
</div>
@endsection
