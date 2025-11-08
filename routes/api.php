<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CultureController;

Route::get('/cultures', [CultureController::class, 'index']);
Route::post('/cultures', [CultureController::class, 'store']);
Route::get('/cultures/{id}', [CultureController::class, 'show']);
Route::put('/cultures/{id}', [CultureController::class, 'update']);
Route::delete('/cultures/{id}', [CultureController::class, 'destroy']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});