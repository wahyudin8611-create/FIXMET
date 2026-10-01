@extends('layouts.admin')
@section('title', 'Aturan Pakar')
@section('page-title', 'Manajemen Aturan Pakar')
@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-gray-600">Total: {{ $rules->total() }} aturan</p>
    <a href="{{ route('admin.rules.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">+ Tambah Aturan</a>
</div>
<div class="bg-white border border-gray-200 rounded-xl">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Kode</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Diagnosis</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Gejala (IF)</th>
                <th class="text-left px-4 py-3 font-medium text-gray-700">Confidence</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($rules as $rule)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $rule->rule_code }}</td>
                <td class="px-4 py-3">
                    <div class="font-medium">{{ $rule->diagnosis->name }}</div>
                    <div class="text-xs text-gray-500">{{ $rule->diagnosis->device->name }}</div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-1">
                        @foreach($rule->symptoms as $s)
                        <span class="bg-blue-100 text-blue-700 text-xs px-1.5 py-0.5 rounded font-mono">{{ $s->code }}</span>
                        @endforeach
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ number_format($rule->confidence_weight * 100) }}%</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1 justify-end">
                        <a href="{{ route('admin.rules.edit', $rule->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200">Edit</a>
                        <form action="{{ route('admin.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada aturan pakar</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $rules->links() }}</div>
</div>
@endsection
