<?php

namespace Modules\WeatherApi\Weather\Services;

use App\Exceptions\ExternalApiException;
use App\Modules\WeatherApi\Weather\DTO\WeatherDto;
use App\Modules\WeatherApi\Weather\DTO\WeatherLocationDto;
use App\Modules\WeatherApi\Weather\Services\OpenWeatherMapService;
use Tests\TestCase;

class OpenWeatherMapServiceTest extends TestCase
{
    /**
     * @return void
     * @throws ExternalApiException
     */
    public function testGetWeatherByCityName()
    {
        $weatherLocationDto = new WeatherLocationDto('8.8.8.8', 'metric','London');

        $weatherDto = app(OpenWeatherMapService::class)->getWeatherByCityName($weatherLocationDto);

        $this->assertInstanceOf(WeatherDto::class, $weatherDto);
        $this->assertIsNumeric($weatherDto->temperature);
        $this->assertIsNumeric($weatherDto->pressure);
        $this->assertIsNumeric($weatherDto->humidity);
        $this->assertIsNumeric($weatherDto->rainChance);
        $this->assertIsNumeric($weatherDto->windSpeed);
        $this->assertIsNumeric($weatherDto->windDegree);
        $this->assertIsString($weatherDto->description);
        $this->assertIsString($weatherDto->icon);
    }
}
