<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id
            || ($user->technician && $user->technician->id === $booking->technician_id)
            || $user->isAdmin();
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}
