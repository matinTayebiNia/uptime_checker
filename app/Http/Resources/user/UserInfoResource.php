<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "status" => "success",
            "user" => [
                "id" => $this->id,
                "name" => $this->name,
                "email" => $this->email,
                "phone" => $this->phone
            ]
        ];
    }
}
