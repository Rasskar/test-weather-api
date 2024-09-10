<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\RegisterUserAction;
use App\Modules\WeatherApi\User\DTO\RegisterUserDto;
use App\Modules\WeatherApi\User\Requests\RegisterUserRequest;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Регистрация пользователя",
     *     description="Процесс регистрации пользователя.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="test-name"),
     *             @OA\Property(property="email", type="string", format="email", description="Email должен быть уникальным.", example="test-email@gmail.com"),
     *             @OA\Property(property="password", type="string", minLength=8, description="Пароль должен быть не меньше 8 символов.", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная регистрация",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="test-name"),
     *                 @OA\Property(property="email", type="string", format="email", example="test-email@gmail.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка регистрации пользователя",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to create user")
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
     * Регистрация пользователя
     * @param RegisterUserRequest $request
     * @param RegisterUserAction $action
     * @return UserResource|JsonResponse
     */
    public function register(RegisterUserRequest $request, RegisterUserAction $action)
    {
        $registerUserDto = new RegisterUserDto(...$request->only('name', 'email', 'password'));

        try {
            $userDto = $action->run($registerUserDto);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }

        return new UserResource($userDto);
    }
}
