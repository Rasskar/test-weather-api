<?php

namespace App\Modules\WeatherApi\Weather\Services;

use App\Exceptions\ExternalApiException;
use App\Modules\WeatherApi\Weather\DTO\WeatherDto;
use App\Modules\WeatherApi\Weather\DTO\WeatherLocationDto;
use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Сервис для получения погоды
 */
class OpenWeatherMapService
{
    /**
     * Получаем погоду по названию города
     * @param WeatherLocationDto $weatherLocationDto
     * @return WeatherDto
     * @throws ExternalApiException
     */
    public function getWeatherByCityName(WeatherLocationDto $weatherLocationDto): WeatherDto
    {
        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $weatherLocationDto->city,
                'appid' => config('services.openweathermap.api_key'),
                'units' => $weatherLocationDto->units
            ]);

            if ($response->failed()) {
                throw new ExternalApiException(
                    $response->json('message', 'Unknown error'),
                    $response->status()
                );
            }

            return new WeatherDto(
                $response->json('main.temp'),
                $response->json('main.pressure'),
                $response->json('main.humidity'),
                $response->json('rain.1h', 0),
                $response->json('wind.speed'),
                $response->json('wind.deg'),
                $response->json('weather.0.description'),
                $this->getIcon($response->json('weather.0.icon'))
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Получение URL иконки погоды по коду
     *
     * @param string $iconCode
     * @return string
     */
    private function getIcon(string $iconCode): string
    {
        return "https://openweathermap.org/img/wn/{$iconCode}.png";
    }
}
