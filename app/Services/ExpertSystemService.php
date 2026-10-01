<?php

namespace App\Services;

use App\Models\Diagnosis;
use App\Models\Rule;
use App\Models\Symptom;
use Illuminate\Database\Eloquent\Collection;

class ExpertSystemService
{
    public function getSymptoms(int $deviceId): Collection
    {
        return Symptom::where('device_id', $deviceId)->get();
    }

    public function processAnswers(int $deviceId, array $answers): array
    {
        // answers: [symptom_id => bool]
        $rules = Rule::with(['ruleSymptoms.symptom', 'diagnosis'])
            ->whereHas('diagnosis', fn ($query) => $query->where('device_id', $deviceId))
            ->get();

        $results = [];

        foreach ($rules as $rule) {
            $matched = $this->matchRule($rule, $answers);
            if ($matched > 0) {
                $results[] = [
                    'rule' => $rule,
                    'diagnosis' => $rule->diagnosis,
                    // Percentage, the same scale as consultations.confidence
                    'confidence' => round($rule->confidence_weight * $matched * 100, 2),
                    'matched_symptoms' => $this->getMatchedSymptoms($rule, $answers),
                ];
            }
        }

        usort($results, fn ($a, $b) => $b['confidence'] <=> $a['confidence']);

        return $results;
    }

    private function matchRule(Rule $rule, array $answers): float
    {
        $conditions = $rule->ruleSymptoms;
        if ($conditions->isEmpty()) {
            return 0;
        }

        $matched = 0;
        $total = $conditions->count();

        foreach ($conditions as $condition) {
            $symptomId = $condition->symptom_id;
            if (isset($answers[$symptomId])) {
                $userAnswer = (bool) $answers[$symptomId];
                if ($userAnswer === $condition->expected_answer) {
                    $matched++;
                } else {
                    return 0; // all conditions must match
                }
            }
        }

        return $matched / $total;
    }

    private function getMatchedSymptoms(Rule $rule, array $answers): array
    {
        $matched = [];
        foreach ($rule->ruleSymptoms as $rs) {
            if (isset($answers[$rs->symptom_id])) {
                $matched[] = $rs->symptom->question;
            }
        }

        return $matched;
    }

    public function determineDiagnosis(array $results): ?array
    {
        if (empty($results)) {
            return null;
        }

        return $results[0];
    }

    public function getRepairability(Diagnosis $diagnosis): array
    {
        return [
            'repairability' => $diagnosis->repairability,
            'severity' => $diagnosis->severity,
            'requires_technician' => $diagnosis->requires_technician,
            'can_self_repair' => in_array($diagnosis->repairability, ['self_repair', 'guided_repair'])
                && ! in_array($diagnosis->severity, ['high', 'critical']),
        ];
    }
}
