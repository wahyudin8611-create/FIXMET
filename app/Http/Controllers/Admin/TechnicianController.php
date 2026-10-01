<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technician;

class TechnicianController extends Controller
{
    public function index()
    {
        $technicians = Technician::with('user')->latest()->paginate(20);
        return view('admin.technicians.index', compact('technicians'));
    }

    public function show(Technician $technician)
    {
        $technician->load('user');
        return view('admin.technicians.show', compact('technician'));
    }

    public function verify(Technician $technician)
    {
        $technician->update(['status' => 'verified']);
        $technician->user->update(['role' => 'technician']);
        return back()->with('success', 'Teknisi berhasil diverifikasi.');
    }

    public function reject(Technician $technician)
    {
        $technician->update(['status' => 'rejected']);
        return back()->with('success', 'Teknisi ditolak.');
    }

    public function suspend(Technician $technician)
    {
        $technician->update(['status' => 'suspended']);
        return back()->with('success', 'Teknisi disuspend.');
    }
}
