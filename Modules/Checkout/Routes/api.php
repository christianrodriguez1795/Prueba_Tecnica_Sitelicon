<?php


use Illuminate\Support\Facades\Route;
use Modules\Checkout\Http\Controllers\AuthController;
use Modules\Checkout\Http\Controllers\CheckoutController;

// Route::middleware('auth')->group(function () {    
Route::post('/register', [AuthController::class, 'store']);

// });


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'createOrder']);
});
