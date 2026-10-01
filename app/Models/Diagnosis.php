<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = [
        'device_id', 'code', 'name', 'description', 'severity', 'repairability',
        'recommendation', 'danger_signs',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }

    public function repairGuides()
    {
        return $this->hasMany(RepairGuide::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function getSeverityLabelAttribute(): string
    {
        return match ($this->severity) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis',
            default => '-',
        };
    }

    public function getRepairabilityLabelAttribute(): string
    {
        return match ($this->repairability) {
            'self_repair' => 'Bisa Diperbaiki Sendiri',
            'guided_repair' => 'Bisa dengan Panduan',
            'technician_required', 'professional_only' => 'Perlu Teknisi',
            'do_not_repair' => 'Jangan Diperbaiki Sendiri',
            default => '-',
        };
    }

    /**
     * Derived from the repairability and severity columns; there is no
     * stored requires_technician column.
     */
    public function getRequiresTechnicianAttribute(): bool
    {
        return $this->repairability !== 'self_repair' || in_array($this->severity, ['high', 'critical']);
    }

    public function getSeverityColorAttribute(): string
    {
        return match ($this->severity) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }
}
