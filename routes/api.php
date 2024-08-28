<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\OrderController;

// Route::middleware('auth:sanctum')->post('/checkout', [OrderController::class, 'checkout']);
Route::post('/checkout', [OrderController::class, 'checkout']);
