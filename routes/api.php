<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CultureController;
use App\Http\Controllers\Api\FavoriteController; // Pastikan controller ini di-import
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\GeminiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Akses Tanpa Token)
|--------------------------------------------------------------------------
*/

// Auth: Login dan Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Budaya: Menampilkan List dan Detail Budaya
Route::get('/cultures', [CultureController::class, 'index']);
Route::get('/cultures/{id}', [CultureController::class, 'show']);

// Chatbot: Chat Budaya (Asumsi ini juga dapat diakses publik atau melalui sesi non-auth)
Route::post('/chat-budaya', [ChatbotController::class, 'chat']);




// Route::get('/chat/{query}', [GeminiController::class, 'chat']);
// Route::get('/oauth2callback', [OAuthController::class, 'handleCallback']);
/*
|--------------------------------------------------------------------------
| 2. PROTECTED ROUTES (Membutuhkan Token Sanctum - User dan Admin)
|--------------------------------------------------------------------------
| Semua rute di bawah ini membutuhkan header Authorization: Bearer <token>
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // Auth: Logout, Update Profil, dan Ganti Kata Sandi
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile/update', [AuthController::class, 'updateProfile']); // Edit Username & Fullname
    Route::put('/profile/password', [AuthController::class, 'changePassword']); // Ganti Kata Sandi

    // Favorite: Semua fitur favorit
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{cultureId}', [FavoriteController::class, 'destroy']); 


    /*
    |--------------------------------------------------------------------------
    | 3. ADMIN ROUTES (Membutuhkan Token DAN Gate is_admin)
    |--------------------------------------------------------------------------
    | Ini adalah rute untuk CRUD Budaya yang hanya boleh diakses Admin.
    */
    Route::middleware('can:is_admin')->group(function () {
        
        // CRUD Budaya
        Route::post('/cultures', [CultureController::class, 'store']);
        Route::put('/cultures/{id}', [CultureController::class, 'update']);
        Route::delete('/cultures/{id}', [CultureController::class, 'destroy']);
    });
});