<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CounterController;
use App\Http\Controllers\Api\DamageController;
use App\Http\Controllers\Api\PhoneController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SparepartController;
use App\Http\Controllers\Api\TechnicianController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('damages', DamageController::class);
    Route::apiResource('counters', CounterController::class);
    Route::apiResource('phones', PhoneController::class);
    Route::apiResource('spareparts', SparepartController::class);
    Route::apiResource('technicians', TechnicianController::class);
    Route::apiResource('services', ServiceController::class);
});

Route::fallback(function () {
    return new ApiResourceFailed('Route or method not found', 'Something wrong', 404);
});
