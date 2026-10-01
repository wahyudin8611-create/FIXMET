<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['category_id', 'name', 'brand', 'model', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function symptoms()
    {
        return $this->hasMany(Symptom::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
