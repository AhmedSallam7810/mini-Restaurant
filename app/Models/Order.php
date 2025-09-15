<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'service_charge',
        'final_amount',
        'payment_option_id',
        'payment_status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateFinalAmount()
    {
        $baseAmount = $this->total_amount - $this->discount_amount;

        if ($this->payment_option_id && !$this->relationLoaded('paymentOption')) {
            $this->load('paymentOption');
        }

        if ($this->paymentOption) {
            $charges = $this->paymentOption->calculateTotalCharges($baseAmount);
            $this->tax_amount = $charges['tax_amount'];
            $this->service_charge = $charges['service_charge'];
            $this->final_amount = $charges['final_amount'];
        } else {
            $this->tax_amount = 0;
            $this->service_charge = 0;
            $this->final_amount = $baseAmount;
        }
    }
}
