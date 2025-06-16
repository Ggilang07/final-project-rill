<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


// Halaman yang tidak butuh login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);

Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// Halaman yang butuh login
Route::middleware('auth')->group(function () {

    Route::resource('/', DashboardController::class);

    Route::resource('submissions', RequestController::class);
    
    Route::post('/validate-request', [RequestController::class, 'validateRequest']);

    Route::resource('accounts', UserController::class);

    Route::get('/profile', function () {
        return view('profile', [
            'title' => 'Profile',
            'heading' => 'Profil Pengguna'
        ]);
    })->name('profile');

    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
