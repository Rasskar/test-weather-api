<?php

namespace App\Modules\WeatherApi\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "email" => $this->resource->email,
            "token" => $this->when($this->resource->token, $this->resource->token),
            "token_expires_at" => $this->when($this->resource->token_expires_at, $this->resource->token_expires_at)
        ];
    }
}
