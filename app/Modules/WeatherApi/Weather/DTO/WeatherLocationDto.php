<?php

namespace App\Modules\WeatherApi\Weather\DTO;

class WeatherLocationDto
{
    /**
     * @param string $ip
     * @param string $units
     * @param string|null $city
     */
    public function __construct(
        public string $ip,
        public string $units,
        public ?string $city = null
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ip' => $this->ip,
            'units' => $this->units,
            'city' => $this->city
        ];
    }
}
