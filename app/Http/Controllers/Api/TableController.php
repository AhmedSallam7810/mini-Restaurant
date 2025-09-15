<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableAvailabilityRequest;
use App\Http\Resources\AvailableTableResource;
use App\Http\Resources\TableResource;
use App\Services\TableService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class TableController extends Controller
{
    use ApiResponseTrait;

    protected TableService $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }


    public function availabile_table(TableAvailabilityRequest $request)
    {
        $date = $request->date;
        $time = $request->time;
        $capacity = $request->capacity ?? 1;

        $availableTables = $this->tableService->getAvailableTables($date, $time, $capacity);

        return $this->successResponse([

            'available_tables' => AvailableTableResource::collection($availableTables),
            'total_available' => $availableTables->count()
        ]);
    }
}
