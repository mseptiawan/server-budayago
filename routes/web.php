<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Server BudayaGo API is running!'
    ]);
});

Route::get('/cek', function () {
    return 'web ok';
});

