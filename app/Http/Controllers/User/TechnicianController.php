<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Technician;
use App\Services\CostEstimationService;
use App\Services\TechnicianMatchingService;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function __construct(
        private TechnicianMatchingService $matching,
        private CostEstimationService $estimation,
    ) {}

    public function index(Request $request)
    {
        $technicians = $this->matching->findAll(
            $request->area,
            $request->specialization
        );

        // Bila dibuka dari hasil diagnosis, hitung estimasi biaya dinamis
        // per teknisi berdasarkan analisis kerusakan AI.
        $estimate = null;
        $perTechnician = [];
        $consultation = $this->consultationInContext($request);

        if ($consultation) {
            $estimate = $this->estimation->for($consultation);
            foreach ($technicians as $technician) {
                $perTechnician[$technician->id] = $this->estimation->perTechnician($estimate, $technician);
            }
        }

        return view('user.technicians.index', compact('technicians', 'estimate', 'perTechnician', 'consultation'));
    }

    public function show(Technician $technician)
    {
        $technician->load('user', 'reviews.user');

        return view('user.technicians.show', compact('technician'));
    }

    /**
     * Konsultasi yang boleh dilihat penampil saat ini (mengikuti aturan
     * ConsultationPolicy: tamu lewat token/link, pemilik, atau admin).
     * Dicari lewat access_token, bukan id berurutan, agar diagnosis tamu
     * lain tidak bisa ditebak.
     */
    private function consultationInContext(Request $request): ?Consultation
    {
        if (! $request->filled('consultation')) {
            return null;
        }

        $consultation = Consultation::with('device.category', 'diagnosis')
            ->where('access_token', $request->string('consultation'))
            ->first();

        if (! $consultation || $consultation->status === 'in_progress') {
            return null;
        }

        if ($consultation->isGuest()) {
            return $consultation;
        }

        $user = $request->user();

        return $user && ($user->id === $consultation->user_id || $user->isAdmin())
            ? $consultation
            : null;
    }
}
