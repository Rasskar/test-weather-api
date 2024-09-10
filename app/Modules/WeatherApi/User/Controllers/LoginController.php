<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\LoginUserActions;
use App\Modules\WeatherApi\User\DTO\LoginUserDto;
use App\Modules\WeatherApi\User\Requests\LoginUserRequest;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
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
