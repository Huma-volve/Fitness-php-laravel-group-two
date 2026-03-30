<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],

            'package' => [
                'id' => $this->trainerPackage->package->id,
                'title' => $this->trainerPackage->package->title,
                'sessions_number' => $this->trainerPackage->package->sessions_number,
                'session_duration' => $this->trainerPackage->package->session_duration,
                'price' => $this->trainerPackage->package->price,
            ],


            'trainer' => [
                'id' => $this->trainerPackage->trainer->id,
                'name' => $this->trainerPackage->trainer->name,
                'email' => $this->trainerPackage->trainer->email,
            ],

            'status' => $this->status,

            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
