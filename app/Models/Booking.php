<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * Statuses in which the user and technician can chat.
     *
     * @var list<string>
     */
    public const CHAT_STATUSES = ['accepted', 'scheduled', 'in_progress', 'completed'];

    protected $fillable = [
        'user_id', 'technician_id', 'consultation_id', 'booking_code',
        'service_date', 'service_time', 'service_address', 'problem_description',
        'estimated_fee', 'status', 'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'estimated_fee' => 'decimal:2',
        ];
    }

    public function chatIsOpen(): bool
    {
        return in_array($this->status, self::CHAT_STATUSES, true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function repairReport()
    {
        return $this->hasOne(RepairReport::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'scheduled' => 'Terjadwal',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => '-',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'accepted' => 'blue',
            'rejected' => 'red',
            'scheduled' => 'indigo',
            'in_progress' => 'purple',
            'completed' => 'green',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }
}
