@extends('layouts.app')
@section('title', 'Lupa Password')
@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h1 class="text-xl font-bold mb-2">Lupa Password</h1>
            <p class="text-gray-500 text-sm mb-6">Masukkan email Anda untuk mendapatkan link reset password.</p>
            @if(session('status'))
                <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">{{ session('status') }}</div>
            @endif
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-primary-600 text-white py-2.5 rounded-lg font-semibold hover:bg-primary-700">Kirim Link Reset</button>
                <a href="{{ route('login') }}" class="block text-center text-sm text-gray-500 hover:text-primary-600">Kembali ke Login</a>
            </form>
        </div>
    </div>
</div>
@endsection
