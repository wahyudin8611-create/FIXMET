<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Services\TechnicianMatchingService;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function __construct(private TechnicianMatchingService $matching) {}

    public function index(Request $request)
    {
        $technicians = $this->matching->findAll(
            $request->area,
            $request->specialization
        );

        return view('user.technicians.index', compact('technicians'));
    }

    public function show(Technician $technician)
    {
        $technician->load('user', 'reviews.user');
        return view('user.technicians.show', compact('technician'));
    }
}
