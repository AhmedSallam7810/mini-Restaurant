<?php

namespace Database\Seeders;

use App\Models\PaymentOption;
use Illuminate\Database\Seeder;

class PaymentOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentOption::create([
            'name' => 'Standard Payment',
            'description' => 'Includes 14% tax and 20% service charge',
            'tax_percentage' => 14.00,
            'service_charge_percentage' => 20.00,
            'is_active' => true,
        ]);

        PaymentOption::create([
            'name' => 'Service Only Payment',
            'description' => 'Includes 15% service charge only (no tax)',
            'tax_percentage' => 0.00,
            'service_charge_percentage' => 15.00,
            'is_active' => true,
        ]);
    }
}
