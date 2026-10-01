@extends('layouts.technician')
@section('title', 'Buat Laporan Perbaikan')
@section('page-title', 'Buat Laporan Perbaikan')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4 text-sm text-gray-600">
        Booking: <strong>{{ $booking->booking_code }}</strong> — {{ $booking->user->name }}
    </div>

    <form action="{{ route('technician.repair-reports.store', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis Aktual <span class="text-red-500">*</span></label>
                <input type="text" name="actual_diagnosis" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tindakan Perbaikan <span class="text-red-500">*</span></label>
                <textarea name="repair_action" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Suku Cadang Digunakan</label>
                <textarea name="parts_used" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Tambahan (Rp)</label>
                <input type="number" name="additional_cost" value="0" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Perbaikan <span class="text-red-500">*</span></label>
                <textarea name="repair_result" rows="2" required placeholder="Berhasil diperbaiki / Perlu penggantian komponen / dll" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Sebelum Perbaikan</label>
                <input type="file" name="images_before[]" multiple accept="image/jpeg,image/png,image/webp" class="text-sm w-full">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Setelah Perbaikan</label>
                <input type="file" name="images_after[]" multiple accept="image/jpeg,image/png,image/webp" class="text-sm w-full">
            </div>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700">
            Simpan Laporan & Tandai Selesai
        </button>
    </form>
</div>
@endsection
