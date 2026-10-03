<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Google Gemini (Interactions API) for structured photo analysis.
 *
 * When the main model is overloaded, rate limited or too slow, the request
 * is sent once more to a fallback model, so the analysis keeps working on
 * the free tier during demand spikes.
 */
class GeminiVisionClient implements VisionModel
{
    private const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/interactions';

    public function isConfigured(): bool
    {
        return filled(config('services.gemini.key'));
    }

    public function analyze(string $system, array $images, string $text, array $schema): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $models = array_values(array_unique(array_filter([
            config('services.gemini.model'),
            config('services.gemini.fallback_model'),
        ])));
        $timeout = (int) config('services.gemini.timeout');

        // Analysis runs inside the upload request, so give PHP room to wait for every model.
        set_time_limit($timeout * count($models) + 30);

        $input = array_map(fn (array $image) => [
            'type' => 'image',
            'data' => $image['data'],
            'mime_type' => $image['media_type'],
        ], $images);
        $input[] = ['type' => 'text', 'text' => $text];

        foreach ($models as $model) {
            try {
                $response = Http::withHeaders(['x-goog-api-key' => config('services.gemini.key')])
                    ->timeout($timeout)
                    ->post(self::ENDPOINT, [
                        'model' => $model,
                        'system_instruction' => $system,
                        'input' => $input,
                        'response_format' => [
                            'type' => 'text',
                            'mime_type' => 'application/json',
                            'schema' => $schema,
                        ],
                        'generation_config' => [
                            'thinking_level' => config('services.gemini.thinking_level'),
                        ],
                    ]);
            } catch (ConnectionException $exception) {
                Log::warning('Gemini photo analysis timed out or could not connect', ['model' => $model, 'error' => $exception->getMessage()]);

                continue;
            }

            if ($response->serverError() || $response->status() === 429) {
                Log::warning('Gemini model unavailable, trying the fallback model', ['model' => $model, 'http_status' => $response->status()]);

                continue;
            }

            if ($response->failed() || $response->json('status') !== 'completed') {
                Log::warning('Gemini photo analysis returned no usable answer', [
                    'model' => $model,
                    'http_status' => $response->status(),
                    'status' => $response->json('status'),
                    'error' => $response->json('error.message') ?? $response->json('errors'),
                ]);

                return null;
            }

            $answer = collect($response->json('steps', []))
                ->flatMap(fn (array $step) => $step['content'] ?? [])
                ->where('type', 'text')
                ->last();

            $decoded = json_decode($answer['text'] ?? '', true);

            return is_array($decoded) ? [...$decoded, 'ai_model' => $model] : null;
        }

        return null;
    }
}
