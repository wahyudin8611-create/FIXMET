<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['consultation_id', 'image_path', 'description', 'created_at'];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
