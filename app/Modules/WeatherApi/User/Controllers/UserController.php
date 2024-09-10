<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\UserInfoAction;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/user",
     *     summary="Получение информации о пользователе",
     *     description="Возвращает информацию о текущем пользователе, используя Bearer токен для аутентификации.",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Bearer токен, полученный при авторизации",
     *         @OA\Schema(
     *             type="string",
     *             example="3|BxfgXjsM4TL0r2DGqE2iPyOXFtn2BOwdIYGmircLb2d4f9c2"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос информации о пользователе",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="test-name"),
     *                 @OA\Property(property="email", type="string", format="email", example="test-email@gmail.com"),
     *                 @OA\Property(property="token", type="string", example="3|BxfgXjsM4TL0r2DGqE2iPyOXFtn2BOwdIYGmircLb2d4f9c2"),
     *                 @OA\Property(property="token_expires_at", type="string", format="date-time", example="10.09.2024 22:28")
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
     *         response=404,
     *         description="Элемент не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not found token")
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
     * Получение информации о пользователе
     * @param Request $request
     * @param UserInfoAction $action
     * @return UserResource|JsonResponse
     */
    public function info(Request $request, UserInfoAction $action)
    {
        try {
            $userDto = $action->run($request);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }

        return new UserResource($userDto);
    }
}
