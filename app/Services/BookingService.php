<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Str;

class BookingService
{
    public function create(array $data): Booking
    {
        $data['booking_code'] = 'BK-' . strtoupper(Str::random(8));
        $data['status'] = 'pending';
        return Booking::create($data);
    }

    public function accept(Booking $booking): void
    {
        $booking->update(['status' => 'accepted']);
    }

    public function reject(Booking $booking, string $reason): void
    {
        $booking->update(['status' => 'rejected', 'rejection_reason' => $reason]);
    }

    public function schedule(Booking $booking): void
    {
        $booking->update(['status' => 'scheduled']);
    }

    public function startWork(Booking $booking): void
    {
        $booking->update(['status' => 'in_progress']);
    }

    public function complete(Booking $booking): void
    {
        $booking->update(['status' => 'completed']);

        // Update technician completed jobs
        $booking->technician->increment('completed_jobs');

        // Recalculate technician rating
        $this->recalculateRating($booking->technician);
    }

    public function cancel(Booking $booking): void
    {
        $booking->update(['status' => 'cancelled']);
    }

    private function recalculateRating(\App\Models\Technician $technician): void
    {
        $avgRating = $technician->reviews()->avg('rating') ?? 0;
        $technician->update(['rating' => round($avgRating, 2)]);
    }
}
