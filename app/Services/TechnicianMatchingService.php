<?php

namespace App\Services;

use App\Models\Technician;
use App\Models\Diagnosis;

class TechnicianMatchingService
{
    public function findForDiagnosis(Diagnosis $diagnosis, ?string $area = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Technician::with('user')
            ->where('status', 'verified')
            ->where('is_verified', true)
            ->where('is_available', true);

        if ($area) {
            $query->where('service_area', 'like', '%' . $area . '%');
        }

        $specialization = $this->mapDiagnosisToSpecialization($diagnosis);
        if ($specialization) {
            $query->where('specialization', 'like', '%' . $specialization . '%');
        }

        return $this->rankTechnicians($query->get());
    }

    public function findAll(?string $area = null, ?string $specialization = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Technician::with('user')
            ->where('status', 'verified')
            ->where('is_verified', true);

        if ($area) {
            $query->where('service_area', 'like', '%' . $area . '%');
        }

        if ($specialization) {
            $query->where('specialization', 'like', '%' . $specialization . '%');
        }

        return $this->rankTechnicians($query->get());
    }

    private function mapDiagnosisToSpecialization(Diagnosis $diagnosis): ?string
    {
        $deviceName = $diagnosis->device->name ?? '';
        $deviceCategory = $diagnosis->device->category->name ?? '';

        $map = [
            'AC' => 'AC & Refrigeration',
            'Laptop' => 'Laptop & Komputer',
            'HP' => 'Handphone',
            'Kulkas' => 'AC & Refrigeration',
            'Motor' => 'Kendaraan',
            'Mobil' => 'Kendaraan',
        ];

        foreach ($map as $key => $spec) {
            if (stripos($deviceName, $key) !== false || stripos($deviceCategory, $key) !== false) {
                return $spec;
            }
        }

        return null;
    }

    private function rankTechnicians(\Illuminate\Database\Eloquent\Collection $technicians): \Illuminate\Database\Eloquent\Collection
    {
        return $technicians->sortByDesc(function ($tech) {
            return ($tech->rating * 0.5) + ($tech->completed_jobs * 0.3) + ($tech->experience_years * 0.2);
        })->values();
    }
}
