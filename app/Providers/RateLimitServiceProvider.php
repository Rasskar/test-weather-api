<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('weather-api-limit', function (Request $request) {
            return Limit::perMinute(45)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'You have exceeded the rate limit of 45 requests per minute.'
                ], Response::HTTP_TOO_MANY_REQUESTS);
            });
        });
    }
}
