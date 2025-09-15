<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run()
    {
        $tables = [
            ['number' => 'T001', 'capacity' => 2, 'status' => 'available'],
            ['number' => 'T002', 'capacity' => 2, 'status' => 'available'],
            ['number' => 'T003', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'T004', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'T005', 'capacity' => 4, 'status' => 'available'],
            ['number' => 'T006', 'capacity' => 6, 'status' => 'available'],
            ['number' => 'T007', 'capacity' => 6, 'status' => 'available'],
            ['number' => 'T008', 'capacity' => 8, 'status' => 'available'],
            ['number' => 'T009', 'capacity' => 8, 'status' => 'available'],
            ['number' => 'T010', 'capacity' => 10, 'status' => 'available'],
            ['number' => 'VIP01', 'capacity' => 12, 'status' => 'available'],
            ['number' => 'VIP02', 'capacity' => 16, 'status' => 'available'],
        ];

        Table::insert($tables);
    }
}
