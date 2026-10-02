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

    /**
     * Largest relative change the photo evidence may apply to a rule's score.
     */
    private const MAX_VISUAL_ADJUSTMENT = 0.25;

    /**
     * Questions that can reveal a dangerous (critical) condition are asked earlier.
     */
    private const CRITICAL_QUESTION_PRIORITY = 1.5;

    /**
     * Minimum AI confidence for a photo assessment to answer a question by itself.
     */
    private const PHOTO_ANSWER_MIN_CONFIDENCE = 0.8;

    /**
     * Symptoms the user already states in their complaint, answered "Ya".
     * The complaint is never used to answer "Tidak".
     *
     * @return array<int, bool> symptom_id => answer
     */
    public function answersFromComplaint(int $deviceId, string $complaint): array
    {
        return Symptom::where('device_id', $deviceId)->get()
            ->filter(fn (Symptom $symptom) => $symptom->isMentionedIn($complaint))
            ->mapWithKeys(fn (Symptom $symptom) => [$symptom->id => true])
            ->all();
    }

    /**
     * Symptoms the AI saw (or saw to be absent) with high confidence in clear photos.
     *
     * @param  array<string, mixed>|null  $visualEvidence
     * @return array<int, bool> symptom_id => answer
     */
    public function answersFromPhotos(?array $visualEvidence): array
    {
        $answers = [];
        foreach ($this->usableVisualAssessments($visualEvidence) as $symptomId => $visual) {
            if ($visual['assessment'] !== 'not_determinable' && $visual['confidence'] >= self::PHOTO_ANSWER_MIN_CONFIDENCE) {
                $answers[$symptomId] = $visual['assessment'] === 'visible';
            }
        }

        return $answers;
    }

    /**
     * Picks the next question for adaptive questioning and estimates how many
     * may still follow. Only symptoms of rules that are still possible and
     * could still beat the best conclusion so far are asked; among those,
     * symptoms of heavy rules that are close to completion come first.
     *
     * @param  array<int, bool>  $answers  symptom_id => answer, known so far
     * @return array{next: Symptom|null, remaining: int}
     */
    public function questionPlan(int $deviceId, array $answers): array
    {
        $rules = $this->rulesFor($deviceId);

        $bestConcluded = $rules
            ->filter(fn (Rule $rule) => $this->isConcluded($rule, $answers))
            ->max(fn (Rule $rule) => (float) $rule->confidence_weight) ?? 0.0;

        $scores = [];
        foreach ($rules as $rule) {
            if ($this->isRuledOut($rule, $answers) || (float) $rule->confidence_weight <= $bestConcluded) {
                continue;
            }

            $unknown = $rule->ruleSymptoms->reject(fn ($condition) => array_key_exists($condition->symptom_id, $answers));
            foreach ($unknown as $condition) {
                $priority = $rule->diagnosis?->severity === 'critical' ? self::CRITICAL_QUESTION_PRIORITY : 1;
                $scores[$condition->symptom_id] = ($scores[$condition->symptom_id] ?? 0) + $rule->confidence_weight * $priority / $unknown->count();
            }
        }

        if ($scores === []) {
            return ['next' => null, 'remaining' => 0];
        }

        uksort($scores, fn (int $a, int $b) => [$scores[$b], $a] <=> [$scores[$a], $b]);

        return ['next' => Symptom::find(array_key_first($scores)), 'remaining' => count($scores)];
    }

    /**
     * Forward chaining over the known answers. When AI photo evidence is
     * available, each matched rule's score is raised when the photos show its
     * symptoms and lowered when they show the opposite. Answers that were
     * themselves taken from the photos are not counted a second time.
     *
     * @param  array<int, bool>  $answers  symptom_id => answer
     * @param  array<string, mixed>|null  $visualEvidence  output of ImageAnalysisService::analyzeUpload()
     * @param  list<int>  $photoAnsweredSymptomIds
     */
    public function processAnswers(int $deviceId, array $answers, ?array $visualEvidence = null, array $photoAnsweredSymptomIds = []): array
    {
        $rules = $this->rulesFor($deviceId);

        $visualAssessments = array_diff_key($this->usableVisualAssessments($visualEvidence), array_flip($photoAnsweredSymptomIds));
        $results = [];

        foreach ($rules as $rule) {
            $matched = $this->matchRule($rule, $answers);
            if ($matched > 0) {
                // Percentage, the same scale as consultations.confidence
                $confidence = round($rule->confidence_weight * $matched * 100, 2);
                $result = [
                    'rule' => $rule,
                    'diagnosis' => $rule->diagnosis,
                    'confidence' => $confidence,
                    'matched_symptoms' => $this->getMatchedSymptoms($rule, $answers),
                ];

                if ($visualAssessments !== []) {
                    $support = $this->visualSupport($rule, $visualAssessments);
                    $result['base_confidence'] = $confidence;
                    $result['visual_support'] = $support;
                    $result['confidence'] = round(min(100, max(0, $confidence * (1 + self::MAX_VISUAL_ADJUSTMENT * $support))), 2);
                }

                $results[] = $result;
            }
        }

        usort($results, fn ($a, $b) => $b['confidence'] <=> $a['confidence']);

        // A diagnosis can be reached by several rules; keep only its best-scoring match
        $bestPerDiagnosis = [];
        foreach ($results as $result) {
            $bestPerDiagnosis[$result['diagnosis']->id] ??= $result;
        }

        return array_values($bestPerDiagnosis);
    }

    /**
     * Assessments from photos the AI judged clear enough, keyed by symptom id.
     *
     * @param  array<string, mixed>|null  $visualEvidence
     * @return array<int, array{assessment: string, confidence: float}>
     */
    private function usableVisualAssessments(?array $visualEvidence): array
    {
        if (($visualEvidence['image_quality'] ?? null) !== 'clear') {
            return [];
        }

        $assessments = [];
        foreach ($visualEvidence['symptoms'] ?? [] as $item) {
            $assessments[(int) $item['symptom_id']] = [
                'assessment' => $item['assessment'],
                'confidence' => (float) $item['confidence'],
            ];
        }

        return $assessments;
    }

    /**
     * How strongly the photos agree with the rule's conditions, from -1
     * (photos contradict every condition) to 1 (photos confirm every one).
     * Symptoms that cannot be seen in a photo count as neutral.
     *
     * @param  array<int, array{assessment: string, confidence: float}>  $visualAssessments
     */
    private function visualSupport(Rule $rule, array $visualAssessments): float
    {
        $conditions = $rule->ruleSymptoms;
        $total = 0.0;

        foreach ($conditions as $condition) {
            $visual = $visualAssessments[$condition->symptom_id] ?? null;
            if ($visual === null || $visual['assessment'] === 'not_determinable') {
                continue;
            }

            $photoShowsSymptom = $visual['assessment'] === 'visible';
            $agrees = $photoShowsSymptom === $condition->expected_answer;
            $total += $agrees ? $visual['confidence'] : -$visual['confidence'];
        }

        return round($total / $conditions->count(), 2);
    }

    /**
     * @return Collection<int, Rule>
     */
    private function rulesFor(int $deviceId): Collection
    {
        return Rule::with(['ruleSymptoms.symptom', 'diagnosis'])
            ->whereHas('diagnosis', fn ($query) => $query->where('device_id', $deviceId))
            ->get();
    }

    /**
     * @param  array<int, bool>  $answers
     */
    private function isRuledOut(Rule $rule, array $answers): bool
    {
        return $rule->ruleSymptoms->contains(
            fn ($condition) => array_key_exists($condition->symptom_id, $answers)
                && $answers[$condition->symptom_id] !== $condition->expected_answer
        );
    }

    /**
     * @param  array<int, bool>  $answers
     */
    private function isConcluded(Rule $rule, array $answers): bool
    {
        return $rule->ruleSymptoms->isNotEmpty() && $rule->ruleSymptoms->every(
            fn ($condition) => array_key_exists($condition->symptom_id, $answers)
                && $answers[$condition->symptom_id] === $condition->expected_answer
        );
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
