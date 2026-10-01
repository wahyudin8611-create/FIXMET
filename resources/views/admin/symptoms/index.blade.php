@extends('layouts.admin')
@section('title', 'Gejala')
@section('page-title', 'Manajemen Gejala')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $symptoms->total() }} gejala</p>
    <a href="{{ route('admin.symptoms.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Gejala</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Kode</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Pertanyaan</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Perangkat</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Bobot</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($symptoms as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $s->code }}</td>
                <td class="px-4 py-3 font-medium">{{ $s->question }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $s->device->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $s->weight }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.symptoms.edit', $s->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.symptoms.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus gejala ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada gejala</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $symptoms->links() }}</div>
</div>
@endsection
