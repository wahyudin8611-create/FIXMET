<?php

namespace App\Services;

/**
 * An AI model that can look at photos and answer with JSON following a schema.
 * The provider is chosen with AI_PROVIDER (gemini or anthropic).
 */
interface VisionModel
{
    public function isConfigured(): bool;

    /**
     * Send photos and instructions to the model and return the JSON object it
     * produced, or null when the model is unavailable, fails or declines.
     *
     * @param  list<array{media_type: string, data: string}>  $images  base64-encoded photos
     * @param  array<string, mixed>  $schema  JSON schema the response must follow
     * @return array<string, mixed>|null
     */
    public function analyze(string $system, array $images, string $text, array $schema): ?array;
}
