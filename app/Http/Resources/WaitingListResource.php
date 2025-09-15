<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WaitingListResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'customer' => new CustomerResource($this->customer),
            'preferred_date' => $this->preferred_date,
            'preferred_time' => $this->preferred_time,
            'capacity' => $this->capacity,
            'status' => $this->status,
        ];
    }
}
