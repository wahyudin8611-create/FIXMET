<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Diagnosis;
use App\Models\Rule;
use App\Models\RuleSymptom;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::with(['diagnosis.device', 'symptoms'])->latest()->paginate(15);
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $devices = Device::with('category')->orderBy('name')->get();
        return view('admin.rules.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'rule_code' => 'required|string|max:20|unique:rules,rule_code',
            'confidence_weight' => 'nullable|numeric|min:0.1|max:1.0',
            'symptom_ids' => 'required|array|min:1',
            'symptom_ids.*' => 'exists:symptoms,id',
        ]);

        $rule = Rule::create([
            'diagnosis_id' => $request->diagnosis_id,
            'rule_code' => strtoupper($request->rule_code),
            'confidence_weight' => $request->confidence_weight ?? 0.8,
        ]);

        foreach ($request->symptom_ids as $symptomId) {
            RuleSymptom::create([
                'rule_id' => $rule->id,
                'symptom_id' => $symptomId,
                'expected_answer' => true,
            ]);
        }

        return redirect()->route('admin.rules.index')->with('success', 'Aturan pakar berhasil ditambahkan.');
    }

    public function edit(Rule $rule)
    {
        $rule->load(['diagnosis.device', 'symptoms']);
        $diagnoses = Diagnosis::where('device_id', $rule->diagnosis->device_id)->orderBy('name')->get();
        $symptoms = $rule->diagnosis->device->symptoms;
        $selectedSymptomIds = $rule->symptoms->pluck('id')->toArray();
        return view('admin.rules.edit', compact('rule', 'diagnoses', 'symptoms', 'selectedSymptomIds'));
    }

    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'rule_code' => 'required|string|max:20|unique:rules,rule_code,' . $rule->id,
            'confidence_weight' => 'nullable|numeric|min:0.1|max:1.0',
            'symptom_ids' => 'required|array|min:1',
            'symptom_ids.*' => 'exists:symptoms,id',
        ]);

        $rule->update([
            'diagnosis_id' => $request->diagnosis_id,
            'rule_code' => strtoupper($request->rule_code),
            'confidence_weight' => $request->confidence_weight ?? 0.8,
        ]);

        $rule->ruleSymptoms()->delete();
        foreach ($request->symptom_ids as $symptomId) {
            RuleSymptom::create([
                'rule_id' => $rule->id,
                'symptom_id' => $symptomId,
                'expected_answer' => true,
            ]);
        }

        return redirect()->route('admin.rules.index')->with('success', 'Aturan pakar berhasil diperbarui.');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return back()->with('success', 'Aturan berhasil dihapus.');
    }

    public function getSymptoms(Device $device)
    {
        return response()->json($device->symptoms()->select('id', 'code', 'question')->get());
    }

    public function getDiagnoses(Device $device)
    {
        return response()->json($device->diagnoses()->select('id', 'name', 'code')->get());
    }
}
