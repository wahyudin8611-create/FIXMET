<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $bookings = Booking::with(['technician.user', 'messages'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['accepted', 'scheduled', 'in_progress', 'completed'])
            ->latest()
            ->get();
        return view('user.messages.index', compact('bookings'));
    }

    public function send(\Illuminate\Http\Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        $request->validate(['message' => 'required|string|max:1000']);
        $booking->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);
        return back();
    }

    public function getMessages(Booking $booking)
    {
        $this->authorize('view', $booking);
        return response()->json($booking->messages()->with('sender')->latest()->get());
    }
}
