<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'menu_item' => new MenuItemResource($this->whenLoaded('menuItem')),
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'subtotal' => $this->subtotal,
        ];
    }
}
