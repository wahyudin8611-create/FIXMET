<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Consultation extends Model
{
    use Prunable;

    /**
     * Days a consultation made without an account is kept before it is pruned.
     */
    public const GUEST_RETENTION_DAYS = 7;

    /**
     * Session key holding the ids of consultations created by the current guest.
     */
    public const GUEST_SESSION_KEY = 'guest_consultations';

    protected $fillable = [
        'user_id', 'device_id', 'diagnosis_id', 'consultation_code',
        'device_brand', 'device_model', 'device_age', 'initial_complaint',
        'status', 'result', 'confidence', 'all_diagnoses', 'visual_evidence',
        'cost_estimate',
    ];

    protected $hidden = ['access_token'];

    protected static function booted(): void
    {
        static::creating(function (Consultation $consultation): void {
            $consultation->access_token ??= Str::random(40);
        });
    }

    protected function casts(): array
    {
        return [
            'confidence' => 'decimal:2',
            'all_diagnoses' => 'array',
            'visual_evidence' => 'array',
            'cost_estimate' => 'array',
        ];
    }

    public function isGuest(): bool
    {
        return $this->user_id === null;
    }

    /**
     * Guest consultations are removed, together with their photos, once the
     * retention window has passed.
     */
    public function prunable(): Builder
    {
        return static::query()
            ->whereNull('user_id')
            ->where('created_at', '<=', now()->subDays(self::GUEST_RETENTION_DAYS));
    }

    protected function pruning(): void
    {
        Storage::disk('public')->delete($this->images()->pluck('image_path')->all());
    }

    /**
     * Guest consultations have no user; existing views still read a name.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Tamu']);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function images()
    {
        return $this->hasMany(ConsultationImage::class);
    }

    public function answers()
    {
        return $this->hasMany(ConsultationAnswer::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
