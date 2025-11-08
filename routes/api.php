<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CultureController;

Route::get('/cultures', [CultureController::class, 'index']);
Route::post('/cultures', [CultureController::class, 'store']);
Route::get('/cultures/{id}', [CultureController::class, 'show']);
Route::put('/cultures/{id}', [CultureController::class, 'update']);
Route::delete('/cultures/{id}', [CultureController::class, 'destroy']);
