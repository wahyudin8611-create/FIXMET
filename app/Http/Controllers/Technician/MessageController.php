<?php

namespace App\Http\Controllers\Technician;

use App\Events\MessageSent;
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
        $this->authorizeBooking($booking);
        $request->validate(['message' => 'required|string|max:1000']);
        $message = $booking->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message, auth()->user()))->toOthers();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'id' => $message->id,
                'message' => $message->message,
                'mine' => true,
                'time' => $message->created_at->format('H:i'),
            ]);
        }

        return back();
    }

    public function getMessages(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $meId = auth()->id();

        $messages = $booking->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn ($msg) => [
                'id' => $msg->id,
                'message' => $msg->message,
                'mine' => $msg->sender_id === $meId,
                'time' => $msg->created_at->format('H:i'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    private function authorizeBooking(Booking $booking): void
    {
        abort_unless($booking->technician_id === auth()->user()->technician?->id, 403);
    }
}
