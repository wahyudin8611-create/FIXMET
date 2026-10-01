<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_id', 'device_id', 'diagnosis_id', 'consultation_code',
        'device_brand', 'device_model', 'device_age', 'initial_complaint',
        'status', 'result', 'confidence', 'all_diagnoses', 'visual_evidence',
    ];

    protected function casts(): array
    {
        return [
            'confidence' => 'decimal:2',
            'all_diagnoses' => 'array',
            'visual_evidence' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
