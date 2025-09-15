<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'tax_percentage',
        'service_charge_percentage',
        'is_active',
    ];

    protected $casts = [
        'tax_percentage' => 'decimal:2',
        'service_charge_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function calculateTotalCharges($baseAmount)
    {
        $tax = $baseAmount * ($this->tax_percentage / 100);
        $serviceCharge = $baseAmount * ($this->service_charge_percentage / 100);

        return [
            'tax_amount' => $tax,
            'service_charge' => $serviceCharge,
            'total_charges' => $tax + $serviceCharge,
            'final_amount' => $baseAmount + $tax + $serviceCharge
        ];
    }
}
