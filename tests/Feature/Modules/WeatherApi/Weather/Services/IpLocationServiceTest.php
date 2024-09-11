<?php

namespace Modules\WeatherApi\Weather\Services;

use App\Exceptions\ExternalApiException;
use App\Modules\WeatherApi\Weather\Services\IpLocationService;
use Tests\TestCase;

class IpLocationServiceTest extends TestCase
{

    /**
     * Тест успешного получения города по реальному IP.
     * @return void
     * @throws ExternalApiException
     */
    public function testGetCityByIpSuccess()
    {
        $city = app(IpLocationService::class)->getCityByIp('8.8.8.8');

        $this->assertNotEmpty($city);
        $this->assertIsString($city);
    }
}
