@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h1 class="text-xl font-bold mb-6">Reset Password</h1>
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', request('email')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary-600 text-white py-2.5 rounded-lg font-semibold hover:bg-primary-700">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
