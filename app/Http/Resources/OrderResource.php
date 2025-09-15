<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'payment_option' => new PaymentOptionResource($this->whenLoaded('paymentOption')),
            'total_amount' => $this->total_amount,
            'discount_amount' => $this->discount_amount,
            'tax_amount' => $this->tax_amount,
            'service_charge' => $this->service_charge,
            'final_amount' => $this->final_amount,
            'payment_status' => $this->payment_status,
        ];
    }
}
