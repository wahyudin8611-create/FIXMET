@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $categories->total() }} kategori</p>
    <a href="{{ route('admin.categories.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Kategori</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Nama</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Slug</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Deskripsi</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Perangkat</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $cat->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $cat->slug }}</td>
                <td class="px-4 py-3 text-gray-600">{{ Str::limit($cat->description, 60) }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $cat->devices_count }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $categories->links() }}</div>
</div>
@endsection
