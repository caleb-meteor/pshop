<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

// admin路由
Route::prefix('admin')->group(base_path('routes/admin.php'));

// h5路由
Route::prefix('h5')->group(function (){
    Route::get('products', [ProductController::class, 'index']);
    Route::put('products/{product}/view-num', [ProductController::class, 'viewNum']);
    Route::post('upload', [UploadController::class, 'upload']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders/preview', [OrderController::class, 'previewOrder']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::post('orders/{order}/voucher', [OrderController::class, 'uploadOrderVoucher']);
});

