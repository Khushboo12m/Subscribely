<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes here are prefixed with /api automatically.
| Example: /api/register, /api/login, /api/subscriptions
|--------------------------------------------------------------------------
*/

//  Public routes (no auth required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Forgot Password routes
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
//  Protected routes (requires valid Sanctum token)
Route::middleware('auth:sanctum')->group(function () {

    // Authentication actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);


    // Subscription management (CRUD)
    Route::apiResource('/subscriptions', SubscriptionController::class);

    // Dashboard APIs
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('/dashboard/upcoming', [DashboardController::class, 'upcomingRenewals']);
    Route::get('/dashboard/monthly', [DashboardController::class, 'monthlyTotals']);

});
