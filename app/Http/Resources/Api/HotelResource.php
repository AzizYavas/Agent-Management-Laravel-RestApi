<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'hotel_id' => $this->hotel_id,
            'room_detail' => $this->room_detail,
            'service_type' => $this->service_type,
            'price' => $this->price,
            'reservation_userid' => $this->reservation_userid,
            'checkin_date' => $this->checkin_date,
            'checkout_date' => $this->checkout_date
        ];
    }
}
