<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['category_id', 'name', 'keywords', 'brand', 'model', 'description'];

    /**
     * Words that identify this device in a complaint: its keywords plus its own name.
     *
     * @return list<string>
     */
    public function recognitionTerms(): array
    {
        $terms = array_map('trim', explode(',', (string) $this->keywords));
        $terms[] = $this->name;

        return array_values(array_unique(array_filter(array_map('mb_strtolower', $terms))));
    }

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
