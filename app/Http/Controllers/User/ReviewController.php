<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        if ($booking->status !== 'completed') {
            return back()->with('error', 'Review hanya dapat diberikan setelah pekerjaan selesai.');
        }

        if ($booking->review) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'technician_id' => $booking->technician_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Recalculate technician rating
        $technician = $booking->technician;
        $avg = $technician->reviews()->avg('rating');
        $technician->update(['rating' => round($avg, 2)]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
