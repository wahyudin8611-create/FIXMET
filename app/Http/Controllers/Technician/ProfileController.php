<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $technician = auth()->user()->technician ?? new Technician();
        return view('technician.profile.edit', compact('technician'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'specialization' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'service_fee' => ['required', 'numeric', 'min:0'],
            'service_area' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'identity_card' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'skill_evidence' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $data = $request->only(['specialization', 'description', 'service_fee', 'service_area', 'experience_years']);

        foreach (['certificate', 'identity_card', 'skill_evidence'] as $doc) {
            if ($request->hasFile($doc)) {
                $path = $request->file($doc)->store('technicians/' . $doc, 'public');
                $data[$doc] = $path;
            }
        }

        $technician = Technician::updateOrCreate(
            ['user_id' => $user->id],
            array_merge($data, ['user_id' => $user->id])
        );

        // Update user role if needed
        if ($user->role !== 'technician') {
            $user->update(['role' => 'technician']);
        }

        return back()->with('success', 'Profil teknisi berhasil disimpan. Menunggu verifikasi admin.');
    }
}
