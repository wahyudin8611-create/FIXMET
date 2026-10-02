<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationAnswer extends Model
{
    public $timestamps = false;

    public const SOURCE_USER = 'user';

    public const SOURCE_COMPLAINT = 'complaint';

    public const SOURCE_PHOTO = 'photo';

    protected $fillable = ['consultation_id', 'symptom_id', 'answer', 'source', 'created_at'];

    protected $attributes = [
        'source' => self::SOURCE_USER,
    ];

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
