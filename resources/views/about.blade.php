@extends('layouts.app')
@section('title', 'Tentang FIXMATE')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Tentang FIXMATE</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Platform AI untuk diagnosis kerusakan elektronik dan koneksi teknisi profesional</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Misi Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                FIXMATE hadir untuk menghubungkan pengguna dengan solusi perbaikan elektronik yang tepat, cepat, dan terpercaya.
                Kami memanfaatkan sistem pakar berbasis kecerdasan buatan untuk membantu mengidentifikasi kerusakan perangkat elektronik
                dan menghubungkan pengguna dengan teknisi profesional terverifikasi.
            </p>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Teknologi Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Sistem Expert System kami menggunakan metode Forward Chaining dengan algoritma pencocokan aturan AND logic.
                Setiap diagnosis menghasilkan nilai confidence yang mencerminkan tingkat keyakinan sistem terhadap kerusakan yang teridentifikasi.
            </p>
        </div>
    </div>

    <div class="bg-primary-50 rounded-2xl p-8 mb-10">
        <h2 class="text-xl font-bold text-gray-900 text-center mb-6">Nilai-Nilai FIXMATE</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['🎯', 'Akurasi', 'Diagnosis berbasis data dan aturan pakar yang telah tervalidasi'],
                ['🔒', 'Kepercayaan', 'Semua teknisi melalui proses verifikasi dan seleksi yang ketat'],
                ['⚡', 'Kecepatan', 'Solusi dan koneksi teknisi dalam hitungan menit'],
            ] as [$icon, $title, $desc])
            <div class="text-center">
                <div class="text-3xl mb-2">{{ $icon }}</div>
                <h3 class="font-bold text-gray-900 mb-1">{{ $title }}</h3>
                <p class="text-gray-600 text-sm">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('register') }}" class="inline-block bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-700">
            Mulai Gunakan FIXMATE
        </a>
    </div>
</div>
@endsection
