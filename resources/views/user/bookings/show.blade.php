@extends('layouts.app')
@section('title', 'Detail Booking')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('user.bookings.index') }}" class="text-sm text-gray-500 hover:text-primary-600 mb-4 inline-block">&larr; Kembali</a>

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden mb-5">
        <div class="p-5 border-b flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-lg font-bold text-gray-900">{{ $booking->booking_code }}</h1>
                <p class="text-sm text-gray-500">{{ $booking->service_date?->format('d M Y') }} pukul {{ $booking->service_time }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-700">
                {{ $booking->status_label }}
            </span>
        </div>

        <div class="p-5 grid md:grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Teknisi</h3>
                <div class="flex items-center gap-2">
                    <img src="{{ $booking->technician->user->profile_photo_url }}" class="w-9 h-9 rounded-full" alt="">
                    <div>
                        <div class="font-medium text-sm text-gray-900">{{ $booking->technician->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->technician->specialization }}</div>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Alamat Layanan</h3>
                <p class="text-sm text-gray-600">{{ $booking->service_address }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Masalah</h3>
                <p class="text-sm text-gray-600">{{ $booking->problem_description }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Estimasi Biaya</h3>
                <p class="text-sm font-semibold text-primary-600">Rp{{ number_format($booking->estimated_fee ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($booking->status === 'pending')
        <div class="p-5 border-t">
            <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Batalkan booking ini?')">
                @csrf @method('PATCH')
                <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100">Batalkan Booking</button>
            </form>
        </div>
        @endif
    </div>

    {{-- Repair Report --}}
    @if($booking->repairReport)
    <div class="bg-white border border-gray-200 rounded-xl p-5 mb-5">
        <h2 class="font-semibold text-gray-900 mb-3">Laporan Perbaikan</h2>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Diagnosis Aktual:</span><br><span class="font-medium">{{ $booking->repairReport->actual_diagnosis }}</span></div>
            <div><span class="text-gray-500">Status Hasil:</span><br><span class="font-medium">{{ $booking->repairReport->repair_result }}</span></div>
            @if($booking->repairReport->additional_cost > 0)
            <div><span class="text-gray-500">Biaya Tambahan:</span><br><span class="font-medium text-primary-600">Rp{{ number_format($booking->repairReport->additional_cost, 0, ',', '.') }}</span></div>
            @endif
        </div>
        @if($booking->repairReport->images->isNotEmpty())
        <div class="mt-3">
            <p class="text-sm font-medium text-gray-700 mb-2">Foto Perbaikan</p>
            <div class="grid grid-cols-4 gap-2">
                @foreach($booking->repairReport->images as $img)
                <img src="{{ $img->url }}" class="w-full h-20 object-cover rounded-lg border border-gray-200" alt="{{ $img->image_type }}">
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Review --}}
    @if($booking->status === 'completed')
        @if($booking->review)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-5">
            <h2 class="font-semibold text-gray-900 mb-1">Ulasan Anda</h2>
            <div class="flex gap-0.5 text-amber-400" aria-label="{{ $booking->review->rating }} dari 5 bintang">@for($star = 1; $star <= 5; $star++)<x-icon name="star" class="w-4 h-4 {{ $star <= $booking->review->rating ? '' : 'text-gray-200' }}" />@endfor</div>
            @if($booking->review->review)
            <p class="text-sm text-gray-700 mt-1">{{ $booking->review->review }}</p>
            @endif
        </div>
        @else
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-5">
            <h2 class="font-semibold text-gray-900 mb-3">Berikan Ulasan</h2>
            <form action="{{ route('user.reviews.store', $booking->id) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating <span class="text-red-500">*</span></label>
                    <select name="rating" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} dari 5</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ulasan</label>
                    <textarea name="review" rows="2" placeholder="Ceritakan pengalaman Anda..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>
                </div>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600">Kirim Ulasan</button>
            </form>
        </div>
        @endif
    @endif

    {{-- Chat --}}
    @if(in_array($booking->status, ['accepted', 'scheduled', 'in_progress', 'completed']))
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="p-4 border-b font-semibold text-gray-900"><x-icon name="chat" class="inline w-4 h-4 mr-1 align-text-bottom" />Chat dengan Teknisi</div>
        <div class="h-64 overflow-y-auto p-4 space-y-3 bg-gray-50" id="chatBox">
            @foreach($booking->messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-3 py-2 rounded-xl text-sm {{ $msg->sender_id === auth()->id() ? 'bg-primary-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }}">
                    {{ $msg->message }}
                    <div class="text-xs opacity-60 mt-0.5">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <form action="{{ route('user.messages.send', $booking->id) }}" method="POST" class="p-3 border-t flex gap-2">
            @csrf
            <input type="text" name="message" placeholder="Ketik pesan..." required maxlength="2000"
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-700">Kirim</button>
        </form>
    </div>
    @endif
</div>

@push('scripts')
<script>
const chatBox = document.getElementById('chatBox');
if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush
@endsection
