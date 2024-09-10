<?php

namespace App\Modules\WeatherApi\Weather\DTO;

class WeatherDto
{
    /**
     * @param float $temperature
     * @param int $pressure
     * @param int $humidity
     * @param int $rainChance
     * @param float $windSpeed
     * @param int $windDegree
     * @param string $description
     * @param string $icon
     */
    public function __construct(
        public float $temperature,
        public int $pressure,
        public int $humidity,
        public int $rainChance,
        public float $windSpeed,
        public int $windDegree,
        public string $description,
        public string $icon
    )
    {
    }
}
