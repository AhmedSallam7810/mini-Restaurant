<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'daily_limit',
        'current_amount',
        'discount',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'daily_limit' => 'integer',
        'current_amount' => 'integer',
        'discount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountedPrice()
    {
        if ($this->discount > 0) {
            return max(0, $this->price - $this->discount);
        }
        return $this->price;
    }
}
