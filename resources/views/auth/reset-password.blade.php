@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="w-12 h-12 rounded-xl bg-fm-primary/10 flex items-center justify-center mb-5">
                <svg class="w-6 h-6 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-fm-dark mb-6">Reset Password</h1>
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', request('email')) }}" required class="ring-focus w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 hover:border-gray-300 transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" required class="ring-focus w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 hover:border-gray-300 transition-all">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="ring-focus w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 hover:border-gray-300 transition-all">
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-semibold" style="box-shadow: 0 8px 20px rgba(61,139,122,0.2);">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
