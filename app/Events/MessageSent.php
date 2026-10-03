<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Disiarkan seketika (ShouldBroadcastNow = tanpa antre) ke dua kanal privat:
 *  - booking.{id}            → sinkronisasi jendela chat yang sedang terbuka
 *  - App.Models.User.{id}    → notifikasi global (toast + push) ke penerima,
 *                              di halaman mana pun ia berada.
 */
class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $senderName;
    public string $senderAvatar;
    public int $recipientId;
    public string $url;

    public function __construct(public Message $message, User $sender)
    {
        $booking = $this->message->booking;

        $this->senderName = $sender->name;
        $this->senderAvatar = $sender->profile_photo_url;

        if ($sender->id === $booking->user_id) {
            // Pengirim = pengguna → penerima = teknisi.
            $this->recipientId = $booking->technician->user_id;
            $this->url = route('technician.bookings.show', $booking->id);
        } else {
            // Pengirim = teknisi → penerima = pengguna.
            $this->recipientId = $booking->user_id;
            $this->url = route('user.bookings.show', $booking->id);
        }
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('booking.'.$this->message->booking_id),
            new PrivateChannel('App.Models.User.'.$this->recipientId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'booking_id' => $this->message->booking_id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->senderName,
            'sender_avatar' => $this->senderAvatar,
            'time' => $this->message->created_at->format('H:i'),
            'url' => $this->url,
        ];
    }
}
