<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::delete('/{order}', [OrderController::class, 'destroy']);
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus']);
        Route::get('/barcode/{barcode}', [OrderController::class, 'getByBarcode']);
    });
});

Route::prefix('customers')->group(function () {
    Route::get('/check/{phone}', [OrderController::class, 'checkCustomer']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::middleware('auth:sanctum')->post('logout', 'logout')->name('logout');
    Route::middleware('auth:sanctum')->put('updateProfile', 'updateProfile')->name('updateProfile');
});
