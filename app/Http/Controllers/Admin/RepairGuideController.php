<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\RepairGuide;
use App\Models\RepairStep;
use Illuminate\Http\Request;

class RepairGuideController extends Controller
{
    public function index()
    {
        $guides = RepairGuide::with('diagnosis.device')->withCount('steps')->paginate(15);
        return view('admin.repair-guides.index', compact('guides'));
    }

    public function create()
    {
        $diagnoses = Diagnosis::with('device')->orderBy('name')->get();
        return view('admin.repair-guides.create', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'estimated_time' => 'required|integer|min:1',
            'tools_needed' => 'nullable|string',
            'cost_range' => 'nullable|string|max:100',
            'do_not_do' => 'nullable|string',
            'steps' => 'nullable|array',
            'steps.*.title' => 'required_with:steps|string|max:255',
            'steps.*.description' => 'required_with:steps|string',
            'steps.*.warning' => 'nullable|string',
        ]);

        $guide = RepairGuide::create($request->only(
            'diagnosis_id', 'title', 'description', 'difficulty',
            'estimated_time', 'tools_needed', 'cost_range', 'do_not_do'
        ));

        foreach ($request->steps ?? [] as $index => $step) {
            RepairStep::create([
                'repair_guide_id' => $guide->id,
                'step_number' => $step['step_number'] ?? ($index + 1),
                'title' => $step['title'],
                'description' => $step['description'],
                'warning' => $step['warning'] ?? null,
            ]);
        }

        return redirect()->route('admin.repair-guides.index')->with('success', 'Panduan perbaikan berhasil ditambahkan.');
    }

    public function edit(RepairGuide $repairGuide)
    {
        $guide = $repairGuide->load('steps');
        $diagnoses = Diagnosis::with('device')->orderBy('name')->get();
        return view('admin.repair-guides.edit', compact('guide', 'diagnoses'));
    }

    public function update(Request $request, RepairGuide $repairGuide)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'title' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'estimated_time' => 'required|integer|min:1',
            'tools_needed' => 'nullable|string',
            'cost_range' => 'nullable|string|max:100',
            'do_not_do' => 'nullable|string',
        ]);

        $repairGuide->update($request->only(
            'diagnosis_id', 'title', 'description', 'difficulty',
            'estimated_time', 'tools_needed', 'cost_range', 'do_not_do'
        ));

        $repairGuide->steps()->delete();
        foreach ($request->steps ?? [] as $index => $step) {
            RepairStep::create([
                'repair_guide_id' => $repairGuide->id,
                'step_number' => $step['step_number'] ?? ($index + 1),
                'title' => $step['title'],
                'description' => $step['description'],
                'warning' => $step['warning'] ?? null,
            ]);
        }

        return redirect()->route('admin.repair-guides.index')->with('success', 'Panduan perbaikan berhasil diperbarui.');
    }

    public function destroy(RepairGuide $repairGuide)
    {
        $repairGuide->delete();
        return back()->with('success', 'Panduan perbaikan berhasil dihapus.');
    }
}
