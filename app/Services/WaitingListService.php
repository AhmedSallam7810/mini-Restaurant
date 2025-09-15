<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\WaitingList;
use Illuminate\Database\Eloquent\Collection;

class WaitingListService
{
    public function addToWaitingList(Customer $customer, string $preferredDate, string $preferredTime, int $capacity)
    {
        $AlreadyExisting = WaitingList::where('customer_id', $customer->id)
            ->where('preferred_date', $preferredDate)
            ->where('preferred_time', $preferredTime)
            ->where('status', 'waiting')
            ->exists();

        if ($AlreadyExisting) {
            return ['success' => false, 'message' => 'Already on waiting list'];
        }

        $waitingListEntry = WaitingList::create([
            'customer_id' => $customer->id,
            'preferred_date' => $preferredDate,
            'preferred_time' => $preferredTime,
            'capacity' => $capacity,
            'status' => 'waiting',
            'priority' => 1
        ]);

        return [
            'success' => true,
            'message' => 'Added to waiting list',
            'data' => ['waiting_list_entry' => $waitingListEntry]
        ];
    }


    public function getWaitingList()
    {
        $wailLists = WaitingList::get();

        return $wailLists;
    }
}
