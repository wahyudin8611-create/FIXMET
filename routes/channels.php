<?php

use App\Models\Booking;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Kanal privat per-booking. Hanya pemilik booking (pengguna) dan teknisi
 * yang ditugaskan pada booking tersebut yang boleh bergabung.
 */
Broadcast::channel('booking.{bookingId}', function ($user, $bookingId) {
    $booking = Booking::find($bookingId);

    if (! $booking) {
        return false;
    }

    $isOwner = (int) $booking->user_id === (int) $user->id;
    $isTechnician = $user->technician && (int) $booking->technician_id === (int) $user->technician->id;

    return $isOwner || $isTechnician;
});
