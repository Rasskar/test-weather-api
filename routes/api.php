<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')
    ->middleware(['throttle:weather-api-limit'])
    ->group(function() {
        Route::post('register', [\App\Modules\WeatherApi\User\Controllers\RegisterController::class, 'register']);
        Route::post('login', [\App\Modules\WeatherApi\User\Controllers\LoginController::class, 'login']);
    });

Route::prefix('v1')
    ->middleware(['auth:sanctum', 'throttle:weather-api-limit'])
    ->group(function() {
        Route::get('user', [\App\Modules\WeatherApi\User\Controllers\UserController::class, 'info']);
        Route::post('weather', [\App\Modules\WeatherApi\Weather\Controllers\WeatherController::class, 'info']);
    });
