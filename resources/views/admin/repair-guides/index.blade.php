@extends('layouts.admin')
@section('title', 'Panduan Perbaikan')
@section('page-title', 'Manajemen Panduan Perbaikan')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $guides->total() }} panduan</p>
    <a href="{{ route('admin.repair-guides.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Panduan</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Judul</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Diagnosis</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Difficulty</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Waktu</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Step</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($guides as $g)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $g->title }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $g->diagnosis->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded text-xs font-medium
                        {{ $g->difficulty === 'easy' ? 'bg-green-100 text-green-700' :
                           ($g->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($g->difficulty) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $g->estimated_time }} mnt</td>
                <td class="px-4 py-3 text-gray-600">{{ $g->steps_count }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.repair-guides.edit', $g->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.repair-guides.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus panduan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada panduan perbaikan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $guides->links() }}</div>
</div>
@endsection
