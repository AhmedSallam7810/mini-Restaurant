<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponseTrait;

    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $bookings = $this->bookingService->getCustomerBookings($request->user()->id, $status);

        return $this->successResponse([
            'bookings' => BookingResource::collection($bookings)
        ]);
    }

    public function store(BookingRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->errorResponse('User not authenticated', 401);
        }

        $result = $this->bookingService->createBooking(
            $user,
            $request->table_id,
            $request->date,
            $request->time,
            $request->notes
        );

        if (!$result['success']) {
            return $this->errorResponse($result['message']);
        }

        return $this->successResponse(
            ['booking' => new BookingResource($result['data'])],
            $result['message']
        );
    }
}
