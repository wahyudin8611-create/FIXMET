<?php

namespace Tests\Feature;

use App\Services\GeminiVisionClient;
use App\Services\VisionModel;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Tests\TestCase;

class GeminiVisionClientTest extends TestCase
{
    private const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/interactions';

    private const SCHEMA = ['type' => 'object', 'properties' => ['device_id' => ['type' => 'integer']], 'required' => ['device_id']];

    protected function setUp(): void
    {
        parent::setUp();

        Sleep::fake();
        config([
            'services.ai.provider' => 'gemini',
            'services.gemini.key' => 'test-key',
            'services.gemini.model' => 'gemini-3.8-flash',
            'services.gemini.fallback_model' => 'gemini-3.5-flash',
            'services.gemini.thinking_level' => 'low',
        ]);
    }

    public function test_gemini_is_the_photo_analysis_provider_when_selected(): void
    {
        $this->assertInstanceOf(GeminiVisionClient::class, app(VisionModel::class));
    }

    public function test_photos_instructions_and_schema_are_sent_in_the_interactions_format(): void
    {
        Http::fake([self::ENDPOINT => Http::response($this->completedInteraction('{"device_id": 3}'))]);

        $result = app(GeminiVisionClient::class)->analyze('Instruksi sistem', [['media_type' => 'image/jpeg', 'data' => 'QUJD']], 'Keluhan pengguna', self::SCHEMA);

        $this->assertSame(['device_id' => 3, 'ai_model' => 'gemini-3.8-flash'], $result);
        Http::assertSent(fn (Request $request) => $request->url() === self::ENDPOINT
            && $request->hasHeader('x-goog-api-key', 'test-key')
            && $request['model'] === 'gemini-3.8-flash'
            && $request['system_instruction'] === 'Instruksi sistem'
            && $request['input'] === [
                ['type' => 'image', 'data' => 'QUJD', 'mime_type' => 'image/jpeg'],
                ['type' => 'text', 'text' => 'Keluhan pengguna'],
            ]
            && $request['response_format'] === ['type' => 'text', 'mime_type' => 'application/json', 'schema' => self::SCHEMA]
            && $request['generation_config'] === ['thinking_level' => 'low']);
    }

    public function test_nothing_is_sent_without_an_api_key(): void
    {
        config(['services.gemini.key' => null]);
        Http::fake();

        $this->assertNull(app(GeminiVisionClient::class)->analyze('', [], '', self::SCHEMA));
        Http::assertNothingSent();
    }

    public function test_unfinished_interaction_gives_no_result(): void
    {
        Http::fake([self::ENDPOINT => Http::response(['status' => 'failed', 'steps' => []])]);

        $this->assertNull(app(GeminiVisionClient::class)->analyze('', [], 'x', self::SCHEMA));
    }

    public function test_invalid_request_does_not_try_the_fallback_model(): void
    {
        Http::fake([self::ENDPOINT => Http::response(['error' => ['message' => 'API key not valid']], 400)]);

        $this->assertNull(app(GeminiVisionClient::class)->analyze('', [], 'x', self::SCHEMA));
        Http::assertSentCount(1);
    }

    public function test_overloaded_model_falls_back_to_the_second_model(): void
    {
        Http::fake([self::ENDPOINT => Http::sequence()
            ->push(['error' => ['message' => 'gemini-3.8-flash is currently experiencing high demand']], 503)
            ->push($this->completedInteraction('{"device_id": 1}'))]);

        $result = app(GeminiVisionClient::class)->analyze('', [], 'x', self::SCHEMA);

        $this->assertSame(['device_id' => 1, 'ai_model' => 'gemini-3.5-flash'], $result);
        Http::assertSentCount(2);
        Http::assertSent(fn (Request $request) => $request['model'] === 'gemini-3.5-flash');
    }

    public function test_timed_out_model_falls_back_to_the_second_model(): void
    {
        Http::fake([self::ENDPOINT => Http::sequence()
            ->pushFailedConnection()
            ->push($this->completedInteraction('{"device_id": 2}'))]);

        $this->assertSame(2, app(GeminiVisionClient::class)->analyze('', [], 'x', self::SCHEMA)['device_id']);
    }

    public function test_no_result_when_every_model_is_unavailable(): void
    {
        Http::fake([self::ENDPOINT => Http::response(['error' => ['message' => 'quota exceeded']], 429)]);

        $this->assertNull(app(GeminiVisionClient::class)->analyze('', [], 'x', self::SCHEMA));
        Http::assertSentCount(2);
    }

    /**
     * @return array<string, mixed>
     */
    private function completedInteraction(string $json): array
    {
        return [
            'id' => 'v1_test',
            'status' => 'completed',
            'steps' => [
                ['type' => 'model_output', 'content' => [['type' => 'text', 'text' => $json]]],
            ],
        ];
    }
}
