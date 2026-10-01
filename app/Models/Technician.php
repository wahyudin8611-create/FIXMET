<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $fillable = [
        'user_id', 'specialization', 'description', 'certificate', 'identity_card',
        'skill_evidence', 'service_fee', 'service_area', 'status', 'rating',
        'completed_jobs', 'is_available', 'is_verified', 'experience_years',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'is_verified' => 'boolean',
            'service_fee' => 'decimal:2',
            'rating' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'verified' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger',
            'suspended' => 'secondary',
            default => 'secondary',
        };
    }
}
