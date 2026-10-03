@extends('layouts.admin')
@section('title', 'Konsultasi')
@section('page-title', 'Daftar Konsultasi')
@section('content')
<div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Pengguna</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Perangkat</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Diagnosis</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Confidence</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Status</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($consultations as $c)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="font-medium">{{ $c->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $c->user->email }}</div>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $c->device->name }}</td>
                <td class="px-4 py-3 font-medium">{{ $c->diagnosis?->name ?? '-' }}</td>
                <td class="px-4 py-3 text-gray-600">
                    @if($c->confidence)
                    <div class="flex items-center gap-2">
                        <div class="w-16 bg-gray-200 rounded-full h-1.5">
                            <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ $c->confidence }}%"></div>
                        </div>
                        <span>{{ number_format($c->confidence, 0) }}%</span>
                    </div>
                    @else — @endif
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded text-xs font-medium
                        {{ $c->status === 'completed' ? 'bg-green-100 text-green-700' :
                           ($c->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                        {{ $c->status }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">{{ $c->created_at->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada konsultasi</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $consultations->links() }}</div>
</div>
@endsection
