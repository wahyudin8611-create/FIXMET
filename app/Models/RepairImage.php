<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['repair_report_id', 'image_path', 'image_type', 'created_at'];

    public function repairReport()
    {
        return $this->belongsTo(RepairReport::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
