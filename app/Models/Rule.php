<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['device_id', 'diagnosis_id', 'rule_code', 'confidence'];

    protected function casts(): array
    {
        return ['confidence' => 'decimal:2'];
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function ruleSymptoms()
    {
        return $this->hasMany(RuleSymptom::class);
    }

    public function symptoms()
    {
        return $this->hasManyThrough(Symptom::class, RuleSymptom::class, 'rule_id', 'id', 'id', 'symptom_id');
    }
}
