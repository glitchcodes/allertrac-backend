<?php

use App\Http\Controllers\AlarmController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

// API v1
Route::prefix('v1')->group(function () {
    // Admin Routes
    Route::prefix('admin')->middleware(['auth:sanctum', IsAdmin::class])->group(function () {
        Route::get('/meal', [MealController::class, 'getFoodDatabase']);
        Route::get('/meal/{id}', [MealController::class, 'getFoodDetails']);
        Route::post('/meal/{id}', [MealController::class, 'updateFoodDetails']);

        Route::get('/facts', [FactController::class, 'getFacts']);
        Route::post('/facts', [FactController::class, 'createFact']);
        Route::patch('/facts/{fact}', [FactController::class, 'editFact']);
        Route::delete('/facts/{fact}', [FactController::class, 'deleteFact']);
    });

    Route::post('/meal/scan', [MealController::class, 'scan']);

    // Authentication Routes
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/login-oauth', [AuthController::class, 'loginOAuth']);
        Route::post('/login/admin', [AuthController::class, 'loginAsAdmin']);
        Route::post('/register', [AuthController::class, 'register']);

        Route::patch('/verify-account', [AuthController::class, 'verifyAccount']);

        Route::get('/check-forget-token/{token}', [AuthController::class, 'validateResetPasswordToken']);
        Route::post('/forgot-password', [AuthController::class, 'createResetPasswordTicket']);
        Route::patch('/reset-password', [AuthController::class, 'resetPassword']);
        Route::patch('/verify-password-request', [AuthController::class, 'verifyResetPasswordTicket']);

        Route::post('/resend-verification', [AuthController::class, 'resendVerificationCode'])
            ->middleware('throttle:resend_verification_code');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/check', [AuthController::class, 'check']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        // User Routes
        Route::get('/user', [UserController::class, 'getCurrentUser']);
        Route::get('/user/check-password', [UserController::class, 'checkPassword']);
        Route::get('/user/miniature', [UserController::class, 'getMiniatureUser']);
        Route::get('/user/allergens', [UserController::class, 'getUserAllergens']);
        Route::get('/user/accounts', [UserController::class, 'getConnectedAccounts']);
        Route::get('/user/alarms', [AlarmController::class, 'getAlarms']);

        Route::post('/user/alarms', [AlarmController::class, 'saveAlarms']);
        Route::post('/user/link-account', [UserController::class, 'linkAccount']);
        Route::patch('/user/unlink-account', [UserController::class, 'unlinkAccount']);
        Route::patch('/user/change-password', [UserController::class, 'changePassword']);
        Route::patch('/user/update-details', [UserController::class, 'updateDetails']);
        Route::patch('/user/update-allergens', [UserController::class, 'updateAllergens']);
        Route::patch('/user/complete-onboarding', [UserController::class, 'completeOnboarding']);

        // Emergency Contact Routes
        Route::get('/contacts', [EmergencyContactController::class, 'index']);
        Route::post('/contacts', [EmergencyContactController::class, 'store']);
        Route::patch('/contacts/{id}', [EmergencyContactController::class, 'update']);
        Route::delete('/contacts/{id}', [EmergencyContactController::class, 'delete']);

        Route::post('/contacts/send', [EmergencyContactController::class, 'sendEmergencyTexts'])
            ->middleware('throttle:send_sms');

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
