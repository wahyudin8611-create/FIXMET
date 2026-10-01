<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['diagnosis_id', 'rule_code', 'confidence_weight'];

    protected function casts(): array
    {
        return ['confidence_weight' => 'decimal:2'];
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
