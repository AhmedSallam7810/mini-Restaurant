<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentOption;

class InvoiceService
{
    public function generateInvoice(Order $order)
    {
        if ($order->payment_status !== 'completed') {
            return ['success' => false, 'message' => 'Order not completed'];
        }

        $invoice = [
            'invoice_number' => 'INV-' . $order->created_at->format('Ymd') . '-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => now()->toDateString(),
            'order_id' => $order->id,
            'customer' => [
                'name' => $order->customer->name,
                'phone' => $order->customer->phone,
                'email' => $order->customer->email
            ],
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'name' => $item->menuItem->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount' => $item->discount,
                    'subtotal' => $item->subtotal
                ];
            }),
            'totals' => [
                'subtotal' => $order->total_amount,
                'discount' => $order->discount_amount,
                'tax' => $order->tax_amount,
                'service_charge' => $order->service_charge,
                'final_amount' => $order->final_amount
            ]
        ];

        return ['success' => true, 'data' => $invoice];
    }

    public function getInvoiceByOrderId(int $orderId, ?int $customerId = null)
    {
        $order = Order::with(['orderItems.menuItem', 'paymentOption', 'customer'])->find($orderId);

        if (!$order) {
            return ['success' => false, 'message' => 'Order not found'];
        }

        return $this->generateInvoice($order);
    }
}
