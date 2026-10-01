<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['user', 'device', 'diagnosis'])->latest()->paginate(20);
        return view('admin.consultations.index', compact('consultations'));
    }
}
