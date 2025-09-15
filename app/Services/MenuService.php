<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public function getAvailableItems()
    {
        return MenuItem::where('is_active', true)
            ->where('current_amount', '>', 0)
            ->get();
    }



    public function checkItemAvailability(int $itemId, int $quantity)
    {
        $item = MenuItem::find($itemId);

        if (!$item || !$item->is_active) {
            return ['available' => false, 'message' => 'Item not available'];
        }

        if ($item->current_amount < $quantity) {
            return [
                'available' => false,
                'message' => 'Not enough quantity',
                'available_quantity' => $item->current_amount
            ];
        }

        return ['available' => true, 'available_quantity' => $item->current_amount];
    }

    public function reserveItems(array $items)
    {
        $reservedItems = [];
        $errors = [];

        // First, check availability for all items without making changes
        foreach ($items as $itemData) {
            $itemId = $itemData['menu_item_id'];
            $quantity = $itemData['quantity'];

            $availability = $this->checkItemAvailability($itemId, $quantity);

            if (!$availability['available']) {
                $errors[] = [
                    'menu_item_id' => $itemId,
                    'message' => $availability['message'],
                    'available_quantity' => $availability['available_quantity'] ?? 0
                ];
            }
        }

        // If any item is not available, return errors without reserving anything
        if (!empty($errors)) {
            return [
                'success' => false,
                'reserved_items' => [],
                'errors' => $errors
            ];
        }

        // All items are available, proceed with reservation using transaction
        DB::beginTransaction();

        try {
            foreach ($items as $itemData) {
                $itemId = $itemData['menu_item_id'];
                $quantity = $itemData['quantity'];

                $item = MenuItem::lockForUpdate()->find($itemId);

                // Double-check availability with lock to prevent race conditions
                if (!$item || !$item->is_active || $item->current_amount < $quantity) {
                    throw new \Exception("Item {$itemId} is no longer available");
                }

                $item->current_amount -= $quantity;
                $item->save();

                $reservedItems[] = [
                    'menu_item_id' => $itemId,
                    'quantity' => $quantity,
                    'unit_price' => $item->price,
                    'discount' => $item->discount
                ];
            }

            DB::commit();

            return [
                'success' => true,
                'reserved_items' => $reservedItems,
                'errors' => []
            ];
        } catch (\Exception $e) {
            DB::rollback();

            return [
                'success' => false,
                'reserved_items' => [],
                'errors' => [['message' => 'Failed to reserve items: ' . $e->getMessage()]]
            ];
        }
    }


    public function releaseItems(array $items)
    {
        foreach ($items as $itemData) {
            $itemId = $itemData['menu_item_id'];
            $quantity = $itemData['quantity'];

            $item = MenuItem::find($itemId);
            if ($item) {
                $item->current_amount += $quantity;
                $item->save();
            }
        }
    }

    public function resetDailyAvailability()
    {
        $count = 0;
        $items = MenuItem::where('is_active', true)->get();

        foreach ($items as $item) {
            $item->current_amount = $item->daily_limit;
            $item->save();
            $count++;
        }

        return $count;
    }
}
