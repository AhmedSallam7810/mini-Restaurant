<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Services\MenuService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ApiResponseTrait;

    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $items = $this->menuService->getAvailableItems();

        return $this->successResponse([
            MenuItemResource::collection($items)
        ]);
    }



    public function checkAvailability(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $availabilityResults = [];
        $allAvailable = true;

        foreach ($request->items as $item) {
            $result = $this->menuService->checkItemAvailability(
                $item['menu_item_id'],
                $item['quantity']
            );

            $availabilityResults[] = array_merge($item, $result);

            if (!$result['available']) {
                $allAvailable = false;
            }
        }

        return $this->successResponse([
            'all_available' => $allAvailable,
            'items' => $availabilityResults
        ]);
    }
}
