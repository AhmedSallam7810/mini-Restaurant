<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Booking;

class TableService
{
    public function getAvailableTables(string $date, string $time, int $capacity = 1)
    {
        return Table::where('status', 'available')
            ->where('capacity', '>=', $capacity)
            ->whereDoesntHave('bookings', function ($query) use ($date, $time) {
                $query->where('date', $date)
                    ->where('time', $time)
                    ->whereIn('status', ['confirmed', 'pending']);
            })
            ->orderBy('capacity')
            ->get();
    }
}
