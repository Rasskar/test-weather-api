<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\RegisterUserAction;
use App\Modules\WeatherApi\User\DTO\RegisterUserDto;
use App\Modules\WeatherApi\User\Requests\RegisterUserRequest;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
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
