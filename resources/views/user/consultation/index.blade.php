@extends('layouts.app')
@section('title', 'Riwayat Diagnosis')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Riwayat Diagnosis</h1>
        <a href="{{ route('diagnosis.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-700">+ Diagnosis Baru</a>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl divide-y">
        @forelse($consultations as $c)
        <a href="{{ route('diagnosis.result', $c) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold">
                {{ strtoupper(substr($c->device->name ?? 'D', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900">{{ $c->device->name }} - {{ $c->device->category->name }}</div>
                <div class="text-sm text-gray-500">{{ $c->diagnosis?->name ?? 'Belum ada diagnosis' }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $c->created_at->diffForHumans() }} · {{ $c->consultation_code }}</div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full {{ $c->status === 'completed' ? 'bg-green-100 text-green-700' : ($c->status === 'no_diagnosis' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ ucfirst(str_replace('_', ' ', $c->status)) }}
            </span>
        </a>
        @empty
        <div class="p-10 text-center">
            <div class="text-4xl mb-3">🔍</div>
            <p class="text-gray-500">Belum ada diagnosis</p>
            <a href="{{ route('diagnosis.create') }}" class="inline-block mt-3 text-primary-600 font-medium text-sm hover:underline">Mulai diagnosis pertama</a>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $consultations->links() }}</div>
</div>
@endsection
