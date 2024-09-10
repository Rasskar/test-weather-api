<?php

namespace App\Modules\WeatherApi\User\DTO;

class LoginUserDto
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
    }

    public function toArray(): array
    {
        return [
            "email" => $this->email,
            "password" => $this->password
        ];
    }
}
