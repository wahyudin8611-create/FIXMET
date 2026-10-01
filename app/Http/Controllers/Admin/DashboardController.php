<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Technician;
use App\Models\Consultation;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_technicians' => Technician::where('status', 'verified')->count(),
            'pending_technicians' => Technician::where('status', 'pending')->count(),
            'total_consultations' => Consultation::count(),
            'total_bookings' => Booking::count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
        ];

        $pendingTechnicians = Technician::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'technician.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingTechnicians', 'recentBookings'));
    }
}
