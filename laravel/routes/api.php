<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\StatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/status-letters', [StatusController::class, 'index']); // list semua surat
    Route::put('/status-letters/{id}/cancel', [StatusController::class, 'cancel'])->where('id', '.*');
    Route::get('/status-letters/{id}', [StatusController::class, 'show'])->where('id', '.*'); // detail surat
    Route::post('/letter-request', [RequestController::class, 'store']);
    Route::get('/categories', [RequestController::class, 'getCategories']);
    Route::get('/profile', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'user']);
});
