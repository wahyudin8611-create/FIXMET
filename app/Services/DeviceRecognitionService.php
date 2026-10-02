<?php

namespace App\Services;

use App\Models\Device;

/**
 * Recognises which supported device a free-text complaint is about, so users
 * never have to pick a category, brand or model themselves.
 */
class DeviceRecognitionService
{
    /**
     * The device whose terms appear most often wins; on a tie, the device
     * mentioned first wins (so "laptop hp saya" is a laptop, not a phone).
     */
    public function recognizeFromText(string $text): ?Device
    {
        $text = mb_strtolower($text);
        $best = null;

        foreach (Device::all() as $device) {
            $hits = 0;
            $firstPosition = PHP_INT_MAX;

            foreach ($device->recognitionTerms() as $term) {
                $pattern = '/(?<![\p{L}\p{N}])'.preg_quote($term, '/').'(?![\p{L}\p{N}])/u';

                if (preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE)) {
                    $hits += count($matches[0]);
                    $firstPosition = min($firstPosition, $matches[0][0][1]);
                }
            }

            if ($hits === 0) {
                continue;
            }

            if ($best === null || $hits > $best['hits'] || ($hits === $best['hits'] && $firstPosition < $best['position'])) {
                $best = ['device' => $device, 'hits' => $hits, 'position' => $firstPosition];
            }
        }

        return $best['device'] ?? null;
    }
}
