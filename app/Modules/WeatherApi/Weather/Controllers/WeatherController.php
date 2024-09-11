<?php

namespace App\Modules\WeatherApi\Weather\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\Weather\Actions\WeatherAction;
use App\Modules\WeatherApi\Weather\DTO\WeatherLocationDto;
use App\Modules\WeatherApi\Weather\Requests\WeatherRequest;
use App\Modules\WeatherApi\Weather\Resources\WeatherResource;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class WeatherController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/weather",
     *     summary="Получение информации о погоде",
     *     description="Возвращает информацию о погоде для указанного города. Если город не передан, используется местоположение по IP.",
     *     tags={"Weather"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"units"},
     *             @OA\Property(
     *                 property="city",
     *                 type="string",
     *                 description="Название города. Если не передано, используется местоположение по IP",
     *                 example="Minsk"
     *             ),
     *             @OA\Property(
     *                 property="units",
     *                 type="string",
     *                 description="Единицы измерения температуры. Допустимые значения: metric, imperial",
     *                 enum={"metric", "imperial"},
     *                 example="metric"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос информации о погоде",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="temperature", type="number", format="float", example=15.26, description="Температура воздуха"),
     *                 @OA\Property(property="pressure", type="integer", example=1009, description="Атмосферное давление"),
     *                 @OA\Property(property="humidity", type="integer", example=46, description="Влажность"),
     *                 @OA\Property(property="rain_chance", type="integer", example=0, description="Вероятность дождя"),
     *                 @OA\Property(property="wind_speed", type="number", format="float", example=2.52, description="Скорость ветра"),
     *                 @OA\Property(property="wind_degree", type="integer", example=149, description="Направление ветра"),
     *                 @OA\Property(property="description", type="string", example="overcast clouds", description="Описание погоды"),
     *                 @OA\Property(property="icon", type="string", example="https://openweathermap.org/img/wn/04n.png", description="Иконка погоды")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Неверный или отсутствующий токен",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Превышен лимит запросов",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Too many requests, please try again later.")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
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
