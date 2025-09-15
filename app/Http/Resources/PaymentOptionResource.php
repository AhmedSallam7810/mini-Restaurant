<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentOptionResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'tax_percentage' => $this->tax_percentage,
            'service_charge_percentage' => $this->service_charge_percentage,
            'is_active' => $this->is_active,
        ];
    }
}
