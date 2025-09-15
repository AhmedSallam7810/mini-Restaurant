<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponseTrait;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $orders = $this->orderService->getCustomerOrders($request->user()->id, $status);

        return $this->successResponse([
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $result = $this->orderService->createOrder(
                $request->user(),
                $request->items
            );

            if (!$result['success']) {
                DB::rollback();
                return $this->errorResponse($result['message'], 400, $result['errors'] ?? null);
            }

            DB::commit();

            return $this->createdResponse(
                ['order' => new OrderResource($result['data'])],
                $result['message']
            );
        } catch (\Exception $e) {
            DB::rollback();

            return $this->errorResponse(
                'Failed to create order: ' . $e->getMessage(),
                500
            );
        }
    }



    public function completePayment(Request $request, int $id)
    {
        $request->validate([
            'payment_option_id' => 'required|integer|exists:payment_options,id'
        ]);

        DB::beginTransaction();

        try {
            $result = $this->orderService->completePayment(
                $id,
                $request->payment_option_id,
                $request->user()->id
            );

            if (!$result['success']) {
                DB::rollback();
                return $this->errorResponse($result['message']);
            }

            DB::commit();

            return $this->successResponse(
                ['order' => new OrderResource($result['data'])],
                $result['message']
            );
        } catch (\Exception $e) {
            DB::rollback();

            return $this->errorResponse(
                'Payment processing failed: ' . $e->getMessage(),
                500
            );
        }
    }
}
