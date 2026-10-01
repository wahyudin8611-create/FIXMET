@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('content')
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Pengguna</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Role</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Telepon</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Konsultasi</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Bergabung</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $u)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <img src="{{ $u->profile_photo_url }}" class="w-8 h-8 rounded-full" alt="">
                        <div>
                            <div class="font-medium">{{ $u->name }}</div>
                            <div class="text-xs text-gray-500">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $u->role === 'admin' ? 'bg-red-100 text-red-700' :
                           ($u->role === 'technician' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $u->phone ?? '-' }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $u->consultations_count ?? 0 }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada pengguna</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $users->links() }}</div>
</div>
@endsection
