@extends('layouts.admin')
@section('title', 'Diagnosis')
@section('page-title', 'Manajemen Diagnosis')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $diagnoses->total() }} diagnosis</p>
    <a href="{{ route('admin.diagnoses.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Diagnosis</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Kode</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Nama</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Perangkat</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Severity</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Repairability</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($diagnoses as $d)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $d->code }}</td>
                <td class="px-4 py-3 font-medium">{{ $d->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $d->device->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded text-xs font-medium
                        {{ match($d->severity) {
                            'low' => 'bg-green-100 text-green-700',
                            'medium' => 'bg-yellow-100 text-yellow-700',
                            'high' => 'bg-orange-100 text-orange-700',
                            'critical' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700'
                        } }}">
                        {{ strtoupper($d->severity) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-600 text-xs">{{ str_replace('_', ' ', strtoupper($d->repairability)) }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.diagnoses.edit', $d->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.diagnoses.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus diagnosis ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada diagnosis</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $diagnoses->links() }}</div>
</div>
@endsection
