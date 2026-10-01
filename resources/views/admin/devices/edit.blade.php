@extends('layouts.admin')
@section('title', 'Edit Perangkat')
@section('page-title', 'Edit Perangkat')
@section('content')
<div class="max-w-lg">
    <form action="{{ route('admin.devices.update', $device->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $device->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perangkat <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $device->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                <input type="text" name="brand" value="{{ old('brand', $device->brand) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                <input type="text" name="model" value="{{ old('model', $device->model) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $device->description) }}</textarea>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-primary-700">Update</button>
            <a href="{{ route('admin.devices.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
@endsection
