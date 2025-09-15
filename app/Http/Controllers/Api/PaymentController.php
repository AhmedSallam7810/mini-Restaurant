<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentOptionResource;
use App\Models\PaymentOption;
use App\Services\InvoiceService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponseTrait;

    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function getPaymentOptions()
    {
        $paymentOptions = PaymentOption::where('is_active', true)
            ->orderBy('name')
            ->get();

        return $this->successResponse([
            'payment_options' => PaymentOptionResource::collection($paymentOptions)
        ]);
    }



    public function getInvoice(Request $request, int $orderId)
    {
        $result = $this->invoiceService->getInvoiceByOrderId(
            $orderId,
            $request->user()->id
        );

        if (!$result['success']) {
            return $this->notFoundResponse($result['message']);
        }

        return $this->successResponse($result['data']);
    }
}
