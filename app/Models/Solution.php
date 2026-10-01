<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = ['diagnosis_id', 'title', 'description', 'solution_type', 'order_number'];

    /**
     * Single line of text the result page shows for this solution.
     */
    public function getSolutionAttribute(): string
    {
        return $this->description ? "{$this->title}: {$this->description}" : $this->title;
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
