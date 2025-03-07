<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::put('orders/{order}/check', [OrderController::class, 'checkOrder']);
    Route::put('orders/{order}/delivery', [OrderController::class, 'delivery']);
    Route::resource('banks', BankController::class)->except('show');
    Route::resource('discounts', DiscountController::class);
    Route::put('discounts/{discount}/effect', [DiscountController::class, 'setEffect']);
    Route::get('statistic', [StatisticController::class, 'getStatistic']);
});
