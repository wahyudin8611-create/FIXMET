<?php

namespace App\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Illuminate\Support\Facades\Log;

/**
 * Thin boundary around the Claude Messages API for structured image analysis.
 */
class ClaudeVisionClient
{
    public function isConfigured(): bool
    {
        return filled(config('services.anthropic.key'));
    }

    /**
     * Send images and instructions to Claude and return the JSON object it
     * produced, or null when the request fails or is declined.
     *
     * @param  list<array<string, mixed>>  $content  user message content blocks (images + text)
     * @param  array<string, mixed>  $schema  JSON schema the response must follow
     * @return array<string, mixed>|null
     */
    public function analyze(string $system, array $content, array $schema): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

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
