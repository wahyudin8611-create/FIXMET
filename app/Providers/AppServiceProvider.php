<?php

namespace App\Providers;

use App\Services\ClaudeVisionClient;
use App\Services\GeminiVisionClient;
use App\Services\VisionModel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VisionModel::class, fn () => match (config('services.ai.provider')) {
            'anthropic' => new ClaudeVisionClient,
            default => new GeminiVisionClient,
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Diagnosis uploads are open to visitors without an account, so photo
     * uploads are throttled to keep the endpoint from being abused.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('diagnosis', function (Request $request): Limit|array {
            if ($request->user()) {
                return Limit::perMinute(10)->by('user:'.$request->user()->id);
            }

            return [
                Limit::perMinute(5)->by('minute:'.$request->ip()),
                Limit::perDay(50)->by('day:'.$request->ip()),
            ];
        });
    }
}
