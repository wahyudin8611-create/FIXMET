<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::with('diagnosis')->paginate(20);
        return view('admin.solutions.index', compact('solutions'));
    }

    public function create()
    {
        $diagnoses = Diagnosis::with('device')->orderBy('name')->get();
        return view('admin.solutions.create', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'solution_type' => 'required|in:preventive,corrective,emergency',
            'order_number' => 'nullable|integer|min:1',
        ]);
        Solution::create($request->only('diagnosis_id', 'title', 'description', 'solution_type', 'order_number'));
        return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil ditambahkan.');
    }

    public function edit(Solution $solution)
    {
        $diagnoses = Diagnosis::with('device')->orderBy('name')->get();
        return view('admin.solutions.edit', compact('solution', 'diagnoses'));
    }

    public function update(Request $request, Solution $solution)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'solution_type' => 'required|in:preventive,corrective,emergency',
            'order_number' => 'nullable|integer|min:1',
        ]);
        $solution->update($request->only('diagnosis_id', 'title', 'description', 'solution_type', 'order_number'));
        return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil diperbarui.');
    }

    public function destroy(Solution $solution)
    {
        $solution->delete();
        return back()->with('success', 'Solusi berhasil dihapus.');
    }
}
