<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentOption;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function createOrder(Customer $customer, array $items)
    {
        $availabilityCheck = $this->menuService->reserveItems($items);
        if (!$availabilityCheck['success']) {
            return ['success' => false, 'message' => 'Items not available', 'errors' => $availabilityCheck['errors']];
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_id' => $customer->id,
                'payment_option_id' => null,
                'payment_status' => 'pending',
                'total_amount' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'service_charge' => 0,
                'final_amount' => 0,
            ]);

            $totalAmount = $totalDiscount = 0;
            foreach ($availabilityCheck['reserved_items'] as $item) {
                $subtotal = ($item['unit_price'] - $item['discount']) * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'discount' => $item['discount'],
                    'subtotal' => $subtotal
                ]);

                $totalAmount += $item['unit_price'] * $item['quantity'];
                $totalDiscount += $item['discount'] * $item['quantity'];
            }

            $order->update([
                'total_amount' => $totalAmount,
                'discount_amount' => $totalDiscount,
            ]);

            $order->calculateFinalAmount();
            $order->save();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load(['orderItems.menuItem'])
            ];
        } catch (\Exception $e) {
            DB::rollback();

            $this->menuService->releaseItems($items);

            return [
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ];
        }
    }

    public function getCustomerOrders(int $customerId, ?string $status = null)
    {
        $query = Order::where('customer_id', $customerId)
            ->with(['orderItems.menuItem', 'paymentOption']);

        if ($status) {
            $query->where('payment_status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getOrderById(int $orderId, ?int $customerId = null)
    {
        $query = Order::with(['orderItems.menuItem', 'paymentOption', 'customer']);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        return $query->find($orderId);
    }

    public function getAvailablePaymentOptions()
    {
        return PaymentOption::where('is_active', true)->get();
    }


    public function completePayment(int $orderId, int $paymentOptionId, ?int $customerId = null)
    {
        $paymentOption = PaymentOption::find($paymentOptionId);
        if (!$paymentOption) {
            return ['success' => false, 'message' => 'Invalid payment option'];
        }

        $order = $this->getOrderById($orderId, $customerId);

        if (!$order) {
            return ['success' => false, 'message' => 'Order not found'];
        }

        if ($order->payment_status !== 'pending') {
            return ['success' => false, 'message' => 'Payment already processed'];
        }

        DB::beginTransaction();

        try {
            $order->payment_option_id = $paymentOptionId;
            $order->load('paymentOption');

            $order->calculateFinalAmount();
            $order->payment_status = 'completed';
            $order->save();


            DB::commit();

            return [
                'success' => true,
                'message' => 'Payment completed successfully',
                'data' => $order->fresh(['orderItems.menuItem', 'paymentOption'])
            ];
        } catch (\Exception $e) {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }
}
