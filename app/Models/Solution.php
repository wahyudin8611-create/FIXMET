<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = ['diagnosis_id', 'solution', 'requires_technician'];

    protected function casts(): array
    {
        return ['requires_technician' => 'boolean'];
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
