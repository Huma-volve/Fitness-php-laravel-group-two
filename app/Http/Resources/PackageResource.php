<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sessions_number' => $this->sessions_number,
            'session_duration' => $this->session_duration,
            'price' => $this->price,

            'created_at' => $this->created_at,
        ];
    }
}
