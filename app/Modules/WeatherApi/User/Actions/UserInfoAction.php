<?php

namespace App\Modules\WeatherApi\User\Actions;

use App\Exceptions\NotFoundException;
use App\Modules\WeatherApi\User\DTO\UserDto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

/**
 * Акшен получение информации о пользователе
 */
class UserInfoAction
{
    /**
     * @param Request $request
     * @return UserDto
     * @throws NotFoundException
     */
    public function run(Request $request): UserDto
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new NotFoundException("Not found user");
            }

            return new UserDto(
                $user->id,
                $user->name,
                $user->email,
                $request->bearerToken(),
                Carbon::parse($user->tokens()->accessToken->expires_at)->format("d.m.Y H:i")
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
