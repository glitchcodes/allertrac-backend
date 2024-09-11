<?php

use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// API v1
Route::prefix('v1')->group(function () {
    // Authentication Routes
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/login-oauth', [AuthController::class, 'loginOAuth']);
        Route::post('/register', [AuthController::class, 'register']);

        Route::patch('/verify-account', [AuthController::class, 'verifyAccount']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerificationCode']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/check', [AuthController::class, 'check']);
        });
    });

    // User Routes
    Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        Route::get('/miniature', [UserController::class, 'getMiniatureUser']);
        Route::patch('/update-details', [UserController::class, 'updateDetails']);
        Route::patch('/update-allergens', [UserController::class, 'updateAllergens']);
    });

    // Fact routes
    Route::prefix('facts')->group(function () {
        Route::get('/category/all', [FactController::class, 'getAllCategories']);
        Route::get('/category/random', [FactController::class, 'getRandomCategories']);
        Route::get('/category/{categoryId}', [FactController::class, 'getFactsByCategory']);
        Route::get('/recent', [FactController::class, 'getRecentFacts']);
        Route::get('/{id}', [FactController::class, 'getFactById']);
    });

    // Allergen Routes
    Route::get('/allergens', [AllergenController::class, 'getAllergens']);
});
