@extends('layouts.app')
@section('title', 'Lupa Password')
@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 rounded-xl bg-fm-primary/10 flex items-center justify-center mb-5">
                <svg class="w-6 h-6 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-fm-dark mb-2">Lupa Password</h1>
            <p class="text-fm-muted text-sm mb-6">Masukkan email Anda untuk mendapatkan link reset password.</p>
            @if(session('status'))
                <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-100 p-3 rounded-xl">{{ session('status') }}</div>
            @endif
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" required class="ring-focus w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 hover:border-gray-300 transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-semibold" style="box-shadow: 0 8px 20px rgba(61,139,122,0.2);">Kirim Link Reset</button>
                <a href="{{ route('login') }}" class="block text-center text-sm text-fm-muted hover:text-fm-primary transition-colors">Kembali ke Login</a>
            </form>
        </div>
    </div>
</div>
@endsection
