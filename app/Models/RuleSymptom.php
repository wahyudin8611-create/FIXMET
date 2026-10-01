<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleSymptom extends Model
{
    public $timestamps = false;

    protected $fillable = ['rule_id', 'symptom_id', 'expected_answer'];

    protected function casts(): array
    {
        return ['expected_answer' => 'boolean'];
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
