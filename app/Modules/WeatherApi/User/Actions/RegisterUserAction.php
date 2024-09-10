<?php

namespace App\Modules\WeatherApi\User\Actions;

use App\Exceptions\SaveException;
use App\Models\User;
use App\Modules\WeatherApi\User\DTO\RegisterUserDto;
use App\Modules\WeatherApi\User\DTO\UserDto;
use Exception;

/**
 * Акшен регистрации пользователя
 */
class RegisterUserAction
{
    /**
     * @param RegisterUserDto $dto
     * @return UserDto
     * @throws SaveException
     */
    public function run(RegisterUserDto $dto): UserDto
    {
        try {
            $user = User::create($dto->toArray());

            if (!$user) {
                throw new SaveException("Failed to create user");
            }

            return new UserDto(
                $user->id,
                $user->name,
                $user->email
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
