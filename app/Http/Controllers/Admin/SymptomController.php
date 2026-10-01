<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::with('device')->paginate(25);
        return view('admin.symptoms.index', compact('symptoms'));
    }

    public function create()
    {
        $devices = Device::with('category')->orderBy('name')->get();
        return view('admin.symptoms.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'code' => 'required|string|max:20|unique:symptoms,code',
            'question' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'nullable|integer|min:1|max:10',
        ]);
        Symptom::create($request->only('device_id', 'code', 'question', 'description', 'weight'));
        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Symptom $symptom)
    {
        $devices = Device::with('category')->orderBy('name')->get();
        return view('admin.symptoms.edit', compact('symptom', 'devices'));
    }

    public function update(Request $request, Symptom $symptom)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'code' => 'required|string|max:20|unique:symptoms,code,' . $symptom->id,
            'question' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'nullable|integer|min:1|max:10',
        ]);
        $symptom->update($request->only('device_id', 'code', 'question', 'description', 'weight'));
        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return back()->with('success', 'Gejala berhasil dihapus.');
    }
}
