<?php

namespace App\Modules\WeatherApi\Weather\Services;

use App\Exceptions\ExternalApiException;
use App\Modules\WeatherApi\Weather\DTO\LocationDto;
use Exception;
use Illuminate\Support\Facades\Http;

class IpLocationService
{
    /**
     * @var string
     */
    protected string $apiUrl = 'http://ip-api.com/json/';

    /**
     * @param string $ip
     * @return string
     * @throws ExternalApiException
     */
    public function getCityByIp(string $ip): string
    {
        try {
            if (!$this->isLocalIp($ip)) {
                $this->apiUrl .= $ip;
            }

            $response = Http::get($this->apiUrl);

            if ($response->failed()) {
                throw new ExternalApiException($response->json('message', 'Unknown error'), $response->status());
            }

            return $response->json('city');
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Проверяем пришёл ли запрос с локального ip
     * @param string $ip
     * @return bool
     */
    private function isLocalIp(string $ip): bool
    {
        $localIps = ['127.0.0.1', '::1'];

        if (in_array($ip, $localIps)) {
            return true;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return true;
        }

        return false;
    }
}
