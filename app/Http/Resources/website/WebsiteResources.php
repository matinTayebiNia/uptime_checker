<?php

namespace App\Http\Resources\website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResources extends JsonResource
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
            "name" => $this->name,
            "url" => $this->url,
            "isHttps" => $this->isHttps,
            "ping" => $this->ping,
            "date_check" => $this->getFormatDateCheck(),
            "status" => $this->getStatus()
        ];
    }

}
