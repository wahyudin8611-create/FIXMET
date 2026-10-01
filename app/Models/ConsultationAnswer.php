<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationAnswer extends Model
{
    public $timestamps = false;

    protected $fillable = ['consultation_id', 'symptom_id', 'answer', 'created_at'];

    protected function casts(): array
    {
        return ['answer' => 'boolean'];
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
