<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WaitingListRequest;
use App\Http\Resources\WaitingListResource;
use App\Services\WaitingListService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    use ApiResponseTrait;

    protected WaitingListService $waitingListService;

    public function __construct(WaitingListService $waitingListService)
    {
        $this->waitingListService = $waitingListService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $entries = $this->waitingListService->getWaitingList();

        return $this->successResponse([
            WaitingListResource::collection($entries)
        ]);
    }

    public function store(WaitingListRequest $request)
    {
        $result = $this->waitingListService->addToWaitingList(
            $request->user(),
            $request->preferred_date,
            $request->preferred_time,
            $request->capacity
        );

        if (!$result['success']) {
            return $this->errorResponse($result['message']);
        }

        return $this->createdResponse($result['data'], $result['message']);
    }
}
