<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairGuide extends Model
{
    protected $fillable = [
        'diagnosis_id', 'title', 'description', 'difficulty', 'estimated_time',
        'risk_level', 'required_tools', 'safety_warning', 'do_not_do',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function steps()
    {
        return $this->hasMany(RepairStep::class)->orderBy('step_number');
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match($this->difficulty) {
            'easy' => 'Mudah',
            'medium' => 'Sedang',
            'hard' => 'Sulit',
            default => '-',
        };
    }
}
