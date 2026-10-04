<?php

namespace App\Http\Controllers\User;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $bookings = Booking::with(['technician.user', 'messages'])
            ->withCount(['messages as unread_count' => fn ($query) => $query
                ->where('is_read', false)
                ->where('sender_id', '!=', auth()->id())])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['accepted', 'scheduled', 'in_progress', 'completed'])
            ->latest()
            ->get();

        return view('user.messages.index', compact('bookings'));
    }

    public function send(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        $request->validate(['message' => 'required|string|max:1000']);
        $message = $booking->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Siaran real-time bersifat opsional: di hosting tanpa server Reverb,
        // pesan tetap tersimpan dan sampai ke lawan bicara lewat polling.
        try {
            broadcast(new MessageSent($message, auth()->user()))->toOthers();
        } catch (\Throwable $e) {
            report($e);
        }

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

        // Membuka/menyegarkan ruang obrolan menandai pesan masuk sebagai dibaca.
        $booking->messages()
            ->where('sender_id', '!=', $meId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

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

    /**
     * Jumlah pesan belum dibaca untuk pengguna + pesan terbaru (toast/suara).
     */
    public function unreadCount()
    {
        $unread = Message::query()
            ->where('is_read', false)
            ->where('sender_id', '!=', auth()->id())
            ->whereHas('booking', fn ($q) => $q->where('user_id', auth()->id()));

        $count = (clone $unread)->count();
        $latest = $unread->with('sender')->latest()->first();

        return response()->json([
            'count' => $count,
            'latest' => $latest ? [
                'id' => $latest->id,
                'booking_id' => $latest->booking_id,
                'sender_name' => $latest->sender->name,
                'sender_avatar' => $latest->sender->profile_photo_url,
                'snippet' => Str::limit($latest->message, 60),
                'url' => route('user.bookings.show', $latest->booking_id),
            ] : null,
        ]);
    }
}
