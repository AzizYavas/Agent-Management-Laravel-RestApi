<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetTransferResource extends JsonResource
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
            'route_id' => $this->route_id,
            'arrival_date' => $this->arrival_date,
            'fly_id' => $this->fly_id,
            'transfer_time' => $this->transfer_time,
            'car_id' => $this->car_id,
            'price' => $this->price,
            'client_id' => $this->client_id,
            'toaccept' => $this->toaccept
        ];
    }
}
