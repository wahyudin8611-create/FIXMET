<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $consultations = $user->consultations()->with('device', 'diagnosis')->latest()->take(5)->get();
        $bookings = $user->bookings()->with('technician.user')->latest()->take(5)->get();

        $stats = [
            'total_diagnosis' => $user->consultations()->count(),
            'total_repair' => $user->bookings()->where('status', 'completed')->count(),
            'active_booking' => $user->bookings()->whereIn('status', ['pending', 'accepted', 'scheduled', 'in_progress'])->count(),
            'completed_repair' => $user->bookings()->where('status', 'completed')->count(),
        ];

        return view('user.dashboard', compact('user', 'consultations', 'bookings', 'stats'));
    }
}
