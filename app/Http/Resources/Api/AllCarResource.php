<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllCarResource extends JsonResource
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
            'category_id' => $this->category_id,
            'brand' => $this->brand,
            'model' => $this->model,
            'capacity' => $this->capacity,
            'luggage' => $this->luggage,
            'clima' => $this->clima,
            'charge' => $this->charge,
            'price' => $this->price
        ];
    }
}
