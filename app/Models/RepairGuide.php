<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairGuide extends Model
{
    protected $fillable = [
        'diagnosis_id', 'title', 'description', 'difficulty', 'estimated_time',
        'cost_range', 'tools_needed', 'do_not_do',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function steps()
    {
        return $this->hasMany(RepairStep::class)->orderBy('step_number');
    }

    /**
     * The guide page reads tools, risk and safety warning under these names;
     * they come from tools_needed and the related diagnosis.
     */
    public function getRequiredToolsAttribute(): ?string
    {
        return $this->tools_needed;
    }

    public function getRiskLevelAttribute(): ?string
    {
        return $this->diagnosis?->severity;
    }

    public function getSafetyWarningAttribute(): ?string
    {
        return $this->diagnosis?->danger_signs;
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'Mudah',
            'medium' => 'Sedang',
            'hard' => 'Sulit',
            default => '-',
        };
    }
}
