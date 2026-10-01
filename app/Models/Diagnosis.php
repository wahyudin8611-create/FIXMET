<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = [
        'device_id', 'name', 'description', 'severity', 'repairability', 'requires_technician',
    ];

    protected function casts(): array
    {
        return ['requires_technician' => 'boolean'];
    }

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
        return match($this->severity) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis',
            default => '-',
        };
    }

    public function getRepairabilityLabelAttribute(): string
    {
        return match($this->repairability) {
            'self_repair' => 'Bisa Diperbaiki Sendiri',
            'guided_repair' => 'Bisa dengan Panduan',
            'technician_required' => 'Perlu Teknisi',
            'do_not_repair' => 'Jangan Diperbaiki Sendiri',
            default => '-',
        };
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }
}
