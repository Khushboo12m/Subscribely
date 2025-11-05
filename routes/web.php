<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SubscriptionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login');
    Route::get('/register', 'registerPage');
    Route::get('/forgot-password', 'forgotPasswordPage');
    Route::get('/verify-otp', 'verifyOtpPage');
    Route::get('/reset-password', 'resetPasswordPage');
});

// Protected routes - authentication handled in JavaScript
// Note: These routes don't use auth:sanctum middleware because tokens are stored in localStorage
// Each Blade view should check authentication in JavaScript before loading data
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);



