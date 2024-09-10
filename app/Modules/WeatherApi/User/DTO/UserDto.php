<?php

namespace App\Modules\WeatherApi\User\DTO;

class UserDto
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string|null $token
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $token = null,
        public ?string $token_expires_at = null
    )
    {
    }
}
