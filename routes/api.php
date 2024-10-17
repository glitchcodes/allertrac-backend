<?php

use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ProxyController;
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
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        // User Routes
        Route::get('/user/miniature', [UserController::class, 'getMiniatureUser']);
        Route::get('/user/allergens', [UserController::class, 'getUserAllergens']);
        Route::patch('/user/update-details', [UserController::class, 'updateDetails']);
        Route::patch('/user/update-allergens', [UserController::class, 'updateAllergens']);

        // Emergency Contact Routes
        Route::get('/contacts', [EmergencyContactController::class, 'index']);
        Route::post('/contacts', [EmergencyContactController::class, 'store']);
        Route::patch('/contacts/{id}', [EmergencyContactController::class, 'update']);
        Route::delete('/contacts/{id}', [EmergencyContactController::class, 'delete']);

        // Meal Routes
        Route::get('/meal/search', [MealController::class, 'search']);
        Route::get('/meal/bookmarks', [MealController::class, 'getBookmarks']);
        Route::post('/meal/bookmarks', [MealController::class, 'createBookmark']);
        Route::delete('/meal/bookmarks/{id}', [MealController::class, 'deleteBookmark']);
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
