<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::delete('/{order}', [OrderController::class, 'destroy']);
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus']);
        Route::get('/barcode/{barcode}', [OrderController::class, 'getByBarcode']);
    });
    Route::prefix('customers')->group(function () {
        Route::get('/check/{phone}', [OrderController::class, 'checkCustomer']);
    });
});
