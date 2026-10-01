<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairReport extends Model
{
    protected $fillable = [
        'booking_id', 'actual_diagnosis', 'repair_action', 'parts_used',
        'additional_cost', 'repair_result', 'notes',
    ];

    protected function casts(): array
    {
        return ['additional_cost' => 'decimal:2'];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(RepairImage::class);
    }

    public function beforeImages()
    {
        return $this->hasMany(RepairImage::class)->where('image_type', 'before');
    }

    public function processImages()
    {
        return $this->hasMany(RepairImage::class)->where('image_type', 'process');
    }

    public function afterImages()
    {
        return $this->hasMany(RepairImage::class)->where('image_type', 'after');
    }
}
