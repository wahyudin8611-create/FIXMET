@extends('layouts.admin')
@section('title', 'Solusi')
@section('page-title', 'Manajemen Solusi')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $solutions->total() }} solusi</p>
    <a href="{{ route('admin.solutions.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Solusi</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Judul</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Diagnosis</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Tipe</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Urutan</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($solutions as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $s->title }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $s->diagnosis->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">{{ $s->solution_type }}</span>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $s->order_number }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.solutions.edit', $s->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.solutions.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus solusi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada solusi</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $solutions->links() }}</div>
</div>
@endsection
