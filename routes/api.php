<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\WaitingListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
});

Route::controller(TableController::class)->prefix('tables')->group(function () {
    Route::get('available', 'availabile_table');
});

Route::controller(MenuController::class)->prefix('menu')->group(function () {
    Route::get('/', 'index');
    Route::post('check_availability', 'checkAvailability');
});

Route::controller(PaymentController::class)->prefix('payment')->group(function () {
    Route::get('options', 'getPaymentOptions');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(TableController::class)->prefix('tables')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(BookingController::class)->prefix('bookings')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });

    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');;
        Route::post('{id}/payment', 'completePayment');
    });

    Route::controller(WaitingListController::class)->prefix('waiting_list')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });

    Route::controller(PaymentController::class)->prefix('invoices')->group(function () {
        Route::get('order/{orderId}', 'getInvoice');
    });
});
