<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['symptom_id', 'question', 'order'];

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
