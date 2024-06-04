<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UptimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "app_name" => $this->app_name,
            "check_per_minute" => $this->check_per_minute,
            "notification_type" => $this->notification_type,
        ];
    }
}
