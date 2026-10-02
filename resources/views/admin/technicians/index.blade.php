@extends('layouts.admin')
@section('title', 'Teknisi')
@section('page-title', 'Manajemen Teknisi')
@section('content')
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Teknisi</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Spesialisasi</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Area</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Rating</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($technicians as $t)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <img src="{{ $t->user->profile_photo_url }}" class="w-8 h-8 rounded-full" alt="">
                        <div>
                            <div class="font-medium">{{ $t->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $t->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $t->specialization }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $t->service_area }}</td>
                <td class="px-4 py-3"><span class="inline-flex items-center gap-1"><x-icon name="star" class="w-4 h-4 text-amber-400" /> {{ number_format($t->rating, 1) }}</span></td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $t->status === 'verified' ? 'bg-green-100 text-green-700' :
                           ($t->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                           ($t->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                        {{ ucfirst($t->status) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.technicians.show', $t->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Detail</a>
                        @if($t->status === 'pending')
                        <form action="{{ route('admin.technicians.verify', $t->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">Verifikasi</button>
                        </form>
                        @elseif($t->status === 'verified')
                        <form action="{{ route('admin.technicians.suspend', $t->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Suspend</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada teknisi</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $technicians->links() }}</div>
</div>
@endsection
