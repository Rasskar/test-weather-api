<?php

namespace App\Modules\WeatherApi\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WeatherApi\User\Actions\UserInfoAction;
use App\Modules\WeatherApi\User\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
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
