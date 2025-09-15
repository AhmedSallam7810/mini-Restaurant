<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Table;

class BookingService
{
    protected TableService $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function createBooking(Customer $customer, int $tableId, string $date, string $time, ?string $notes = null)
    {

        $table = Table::find($tableId);
        if (!$table) {
            return [
                'success' => false,
                'message' => 'Table not found.'
            ];
        }
        if ($this->isTableReservedForDateTime($tableId, $date, $time)) {
            return [
                'success' => false,
                'message' => 'Table is already reserved for this date and time.'
            ];
        }

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'table_id' => $tableId,
            'date' => $date,
            'time' => $time,
            'status' => 'confirmed',
            'notes' => $notes
        ]);

        return [
            'success' => true,
            'message' => 'Booking created successfully.',
            'data' => $booking->load(['customer', 'table'])
        ];
    }




    public function getCustomerBookings(int $customerId)
    {
        return  Booking::where('customer_id', $customerId)
            ->with(['table'])->get();
    }




    public function isTableReservedForDateTime(int $tableId, string $date, string $time): bool
    {
        return Booking::where('table_id', $tableId)
            ->where('date', $date)
            ->where('time', $time)
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }
}
