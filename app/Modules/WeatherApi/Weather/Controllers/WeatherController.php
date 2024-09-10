<?php

namespace App\Modules\WeatherApi\Weather\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\Weather\Actions\WeatherAction;
use App\Modules\WeatherApi\Weather\DTO\WeatherLocationDto;
use App\Modules\WeatherApi\Weather\Requests\WeatherRequest;
use App\Modules\WeatherApi\Weather\Resources\WeatherResource;
use Exception;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{

    /**
     * Получение данных о погоде
     *
     * @param WeatherRequest $request
     * @param WeatherAction $action
     * @return WeatherResource|JsonResponse
     */
    public function info(WeatherRequest $request, WeatherAction $action)
    {
        $weatherLocationDto = new WeatherLocationDto(
            $request->ip(),
            $request->input('units'),
            $request->input('city')
        );

        try {
            $weatherDto = $action->run($weatherLocationDto);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }

        return new WeatherResource($weatherDto);
    }
}
