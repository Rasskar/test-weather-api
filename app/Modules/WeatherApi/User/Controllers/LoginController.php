<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\LoginUserActions;
use App\Modules\WeatherApi\User\DTO\LoginUserDto;
use App\Modules\WeatherApi\User\Requests\LoginUserRequest;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Авторизация пользователя",
     *     description="Процесс авторизации пользователя с получением токена.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="test-email@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная авторизация",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="test-name"),
     *                 @OA\Property(property="email", type="string", format="email", example="test-email@gmail.com"),
     *                 @OA\Property(property="token", type="string", example="1|IHK2E1DunUijLbKZKOAHyLqFSVNGBdv3bkriY3OA4bf72158"),
     *                 @OA\Property(property="token_expires_at", type="string", format="date-time", example="10.09.2024 21:40")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Ошибка авторизации",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Authorization error, check your email or password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка создания токена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to create token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Превышен лимит запросов",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Too many requests, please try again later.")
     *         )
     *     )
     * )
     *
     * Авторизация пользователя
     * @param LoginUserRequest $request
     * @param LoginUserActions $action
     * @return UserResource|JsonResponse
     */
    public function login(LoginUserRequest $request, LoginUserActions $action)
    {
        $loginUserDto = new LoginUserDto(...$request->only( "email", "password"));

        try {
            $userDto = $action->run($loginUserDto);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }

        return new UserResource($userDto);
    }
}
