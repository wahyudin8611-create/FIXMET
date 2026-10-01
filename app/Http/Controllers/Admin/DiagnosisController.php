<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Device;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::with('device')->paginate(20);
        return view('admin.diagnoses.index', compact('diagnoses'));
    }

    public function create()
    {
        $devices = Device::orderBy('name')->get();
        return view('admin.diagnoses.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'code' => 'required|string|max:20|unique:diagnoses,code',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'repairability' => 'required|in:self_repair,professional_only,do_not_repair',
            'recommendation' => 'nullable|string',
            'danger_signs' => 'nullable|string',
        ]);
        Diagnosis::create($request->only('device_id', 'code', 'name', 'description', 'severity', 'repairability', 'recommendation', 'danger_signs'));
        return redirect()->route('admin.diagnoses.index')->with('success', 'Diagnosis berhasil ditambahkan.');
    }

    public function edit(Diagnosis $diagnosis)
    {
        $devices = Device::orderBy('name')->get();
        return view('admin.diagnoses.edit', compact('diagnosis', 'devices'));
    }

    public function update(Request $request, Diagnosis $diagnosis)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'code' => 'required|string|max:20|unique:diagnoses,code,' . $diagnosis->id,
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'severity' => 'required|in:low,medium,high,critical',
            'repairability' => 'required|in:self_repair,professional_only,do_not_repair',
            'recommendation' => 'nullable|string',
            'danger_signs' => 'nullable|string',
        ]);
        $diagnosis->update($request->only('device_id', 'code', 'name', 'description', 'severity', 'repairability', 'recommendation', 'danger_signs'));
        return redirect()->route('admin.diagnoses.index')->with('success', 'Diagnosis berhasil diperbarui.');
    }

    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();
        return back()->with('success', 'Diagnosis berhasil dihapus.');
    }
}
