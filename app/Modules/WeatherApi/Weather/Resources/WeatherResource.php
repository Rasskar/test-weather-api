<?php

namespace App\Modules\WeatherApi\Weather\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'temperature' => $this->resource->temperature,
            'pressure' => $this->resource->pressure,
            'humidity' => $this->resource->humidity,
            'rain_chance' => $this->resource->rainChance,
            'wind_speed' => $this->resource->windSpeed,
            'wind_degree' => $this->resource->windDegree,
            'description' => $this->resource->description,
            'icon' => $this->resource->icon
        ];
    }
}
