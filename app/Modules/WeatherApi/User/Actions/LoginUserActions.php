<?php

namespace App\Modules\WeatherApi\User\Actions;

use App\Exceptions\AuthException;
use App\Exceptions\SaveException;
use App\Modules\WeatherApi\User\DTO\LoginUserDto;
use App\Modules\WeatherApi\User\DTO\UserDto;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Акшен авторизации пользователя
 */
class LoginUserActions
{
    /**
     * @param LoginUserDto $dto
     * @return UserDto
     * @throws AuthException
     * @throws SaveException
     */
    public function run(LoginUserDto $dto): UserDto
    {
        try {
            if (!Auth::attempt($dto->toArray())) {
                throw new AuthException("Authorization error, check your email or password");
            }

            $user = Auth::user();
            $user->tokens()->where('name', 'weather-api-token')->delete();
            $token = $user->createToken('weather-api-token', ['*'], Carbon::now()->addHour());

            if (!$token) {
                throw new SaveException("Failed to create token");
            }

            return new UserDto(
                $user->id,
                $user->name,
                $user->email,
                $token->plainTextToken,
                Carbon::parse($token->accessToken->expires_at)->format("d.m.Y H:i")
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
