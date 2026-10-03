<?php

namespace App\Http\Controllers\User;

use App\Events\MessageSent;
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
        $this->authorize('view', $booking);

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
}
