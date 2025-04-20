<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaundryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/statistics', [OrderController::class, 'statistics']);
        Route::get('/barcode/{barcode}', [OrderController::class, 'getByBarcode']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::delete('/{order}', [OrderController::class, 'destroy']);
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus']);
    });
    Route::prefix('laundries')->group(function () {
        // Route::get('/', [LaundryController::class, 'indexLaundries']);
        // Route::post('/', [LaundryController::class, 'storeLaundry']);
        // Route::get('/{laundry}', [LaundryController::class, 'showLaundry']);
        // Route::delete('/{laundry}', [LaundryController::class, 'destroyLaundry']);

        // rute untuk service
        Route::get('/{laundry}/services', [ServiceController::class, 'index']);
        Route::post('/{laundry}/services', [ServiceController::class, 'store']);
    });
});

Route::middleware(['api'])->group(function () {
    Route::prefix('laundries')->group(function () {
        Route::get('/', [LaundryController::class, 'index']);
        Route::get('/{laundry}', [LaundryController::class, 'show']);
    });
});

Route::prefix('customers')->group(function () {
    Route::get('/check/{phone}', [OrderController::class, 'checkCustomer']);
    Route::get('/{phone}/orders', [OrderController::class, 'trackOrders']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::middleware('auth:sanctum')->post('logout', 'logout')->name('logout');
    Route::middleware('auth:sanctum')->put('updateProfile', 'updateProfile')->name('updateProfile');
    // get users
    Route::middleware('auth:sanctum')->get('user', 'getUser')->name('user');
});
