<?php

namespace App\Modules\WeatherApi\Weather\Actions;

use App\Exceptions\ExternalApiException;
use App\Modules\WeatherApi\Weather\DTO\WeatherDto;
use App\Modules\WeatherApi\Weather\DTO\WeatherLocationDto;
use App\Modules\WeatherApi\Weather\Services\IpLocationService;
use App\Modules\WeatherApi\Weather\Services\OpenWeatherMapService;
use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * Акшен для получения информации о погоде
 */
class WeatherAction
{
    protected const CACHE_EXPIRATION = 3600; // Время жизни кэша в секундах

    /**
     * @param IpLocationService $ipLocationService
     * @param OpenWeatherMapService $openWeatherMapService
     */
    public function __construct(
        protected IpLocationService $ipLocationService,
        protected OpenWeatherMapService $openWeatherMapService
    )
    {
    }

    /**
     * Основная логика для получения данных о погоде
     *
     * @param WeatherLocationDto $weatherLocationDto
     * @return WeatherDto
     * @throws ExternalApiException
     */
    public function run(WeatherLocationDto $weatherLocationDto): WeatherDto
    {
        try {
            if (empty($weatherLocationDto->city)) {
                $weatherLocationDto->city = $this->ipLocationService->getCityByIp($weatherLocationDto->ip);
            }

            $cacheKey = $this->generateCacheKey($weatherLocationDto);

            return Cache::remember($cacheKey, self::CACHE_EXPIRATION, function () use ($weatherLocationDto) {
                return $this->openWeatherMapService->getWeatherByCityName($weatherLocationDto);
            });
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Генерация ключа для кэширования на основе города и единиц измерения
     *
     * @param WeatherLocationDto $weatherLocationDto
     * @return string
     */
    private function generateCacheKey(WeatherLocationDto $weatherLocationDto): string
    {
        return sprintf(
            'weather:city:%s:units:%s',
            urlencode($weatherLocationDto->city),
            $weatherLocationDto->units
        );
    }
}
