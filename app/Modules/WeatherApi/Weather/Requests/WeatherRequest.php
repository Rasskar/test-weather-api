<?php

namespace App\Modules\WeatherApi\Weather\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "city" => ['nullable', 'string', 'max:255'],
            "units" => ['required', 'in:metric,imperial']
        ];
    }
}
