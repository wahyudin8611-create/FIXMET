<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $fillable = ['device_id', 'code', 'question', 'keywords', 'description', 'weight'];

    /**
     * Words that negate the phrase right after them ("tidak panas").
     */
    private const NEGATION_PATTERN = '/(?:^|[^\p{L}])(?:tidak|tak|gak|nggak|ngga|enggak|ga|bukan|tanpa|belum)\s+(?:\p{L}+\s+)?$/u';

    /**
     * Whether the complaint states this symptom in a non-negated way.
     */
    public function isMentionedIn(string $text): bool
    {
        $text = mb_strtolower($text);
        $phrases = array_filter(array_map(fn (string $phrase) => mb_strtolower(trim($phrase)), explode(',', (string) $this->keywords)));

        foreach ($phrases as $phrase) {
            $pattern = '/(?<![\p{L}\p{N}])'.preg_quote($phrase, '/').'(?![\p{L}\p{N}])/u';

            if (! preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE)) {
                continue;
            }

            foreach ($matches[0] as [, $offset]) {
                $before = mb_strcut($text, max(0, $offset - 30), min(30, $offset));
                if (! preg_match(self::NEGATION_PATTERN, $before)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Views display a symptom by its question text.
     */
    public function getNameAttribute(): ?string
    {
        return $this->question;
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function ruleSymptoms()
    {
        return $this->hasMany(RuleSymptom::class);
    }

    public function consultationAnswers()
    {
        return $this->hasMany(ConsultationAnswer::class);
    }
}
