<?php

namespace App\Modules\WeatherApi\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "string"],
            "password" => ["required", "string"]
        ];
    }
}
