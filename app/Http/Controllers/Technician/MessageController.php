<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $technician = auth()->user()->technician;
        $bookings = Booking::with(['user', 'messages'])
            ->where('technician_id', $technician->id)
            ->whereIn('status', ['accepted', 'scheduled', 'in_progress', 'completed'])
            ->latest()
            ->get();
        return view('technician.messages.index', compact('bookings'));
    }

    public function send(Request $request, Booking $booking)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $booking->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);
        return back();
    }
}
