<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $technician = auth()->user()->technician;

        if (!$technician) {
            return redirect()->route('technician.profile.edit')
                ->with('info', 'Lengkapi profil teknisi Anda terlebih dahulu.');
        }

        $bookings = $technician->bookings()->with('user', 'consultation.device')->latest()->take(5)->get();

        $stats = [
            'pending' => $technician->bookings()->where('status', 'pending')->count(),
            'in_progress' => $technician->bookings()->whereIn('status', ['accepted', 'scheduled', 'in_progress'])->count(),
            'completed' => $technician->bookings()->where('status', 'completed')->count(),
            'rating' => $technician->rating,
        ];

        return view('technician.dashboard', compact('technician', 'bookings', 'stats'));
    }
}
