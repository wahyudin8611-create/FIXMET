<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $fillable = ['device_id', 'name', 'code', 'description'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function ruleSymptoms()
    {
        return $this->hasMany(RuleSymptom::class);
    }

    public function consultationAnswers()
    {
        return $this->hasMany(ConsultationAnswer::class);
    }
}
