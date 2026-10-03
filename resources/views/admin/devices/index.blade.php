@extends('layouts.admin')
@section('title', 'Perangkat')
@section('page-title', 'Manajemen Perangkat')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $devices->total() }} perangkat</p>
    <a href="{{ route('admin.devices.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Perangkat</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Nama</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Kategori</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Brand</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Gejala</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($devices as $d)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $d->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $d->category->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $d->brand ?? '-' }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $d->symptoms_count }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.devices.edit', $d->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.devices.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus perangkat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada perangkat</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $devices->links() }}</div>
</div>
@endsection
