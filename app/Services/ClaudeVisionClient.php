<?php

namespace App\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Illuminate\Support\Facades\Log;

/**
 * Thin boundary around the Claude Messages API for structured image analysis.
 */
class ClaudeVisionClient implements VisionModel
{
    public function isConfigured(): bool
    {
        return filled(config('services.anthropic.key'));
    }

    public function analyze(string $system, array $images, string $text, array $schema): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $content = array_map(fn (array $image) => [
            'type' => 'image',
            'source' => ['type' => 'base64', 'mediaType' => $image['media_type'], 'data' => $image['data']],
        ], $images);
        $content[] = ['type' => 'text', 'text' => $text];

        $timeout = (float) config('services.anthropic.timeout');

        // Analysis runs inside the upload request, so give PHP room to wait for it.
        set_time_limit((int) ceil($timeout) * 2 + 30);

        $client = new Client(
            apiKey: config('services.anthropic.key'),
            requestOptions: ['timeout' => $timeout, 'maxRetries' => 1],
        );

        try {
            $message = $client->beta->messages->create(
                model: config('services.anthropic.model'),
                maxTokens: 16000,
                system: $system,
                messages: [['role' => 'user', 'content' => $content]],
                outputConfig: [
                    'effort' => config('services.anthropic.effort'),
                    'format' => ['type' => 'json_schema', 'schema' => $schema],
                ],
                fallbacks: 'default',
                betas: ['server-side-fallback-2026-07-01'],
            );
        } catch (APIException $exception) {
            Log::warning('Photo analysis request failed', ['error' => $exception->getMessage()]);

            return null;
        }

        if ($message->stopReason === 'refusal' || $message->stopReason === 'max_tokens') {
            Log::warning('Photo analysis returned no usable answer', ['stop_reason' => $message->stopReason]);

            return null;
        }

        foreach ($message->content as $block) {
            if ($block->type === 'text') {
                $decoded = json_decode($block->text, true);

                return is_array($decoded) ? [...$decoded, 'ai_model' => $message->model] : null;
            }
        }

        return null;
    }
}
