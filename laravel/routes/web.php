<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('dashboard', [
        'title' => 'Admin Dashboard',
        'heading' => 'Dashboard'
    ]);
});

Route::get('/letter-submission', function () {
    return view('letter-submission', [
        'title' => 'letter Submission',
        'heading' => 'Pengajuan Surat'
    ]);
});

// Route::get('/accounts', function () {
//     return view('register-account', [
//         'title' => 'Accounts',
//         'heading' => 'Akun Pengguna',
//         'accounts' => User::all() 
//     ]);
// });

Route::resource('accounts', UserController::class);
// Route::get('accounts/{user_id}', [UserController::class, 'edit'])->name('accounts.edit');
// Route::put('accounts/{user_id}', [UserController::class, 'update'])->name('accounts.update');
// Route::get('accounts/{user_id}', [UserController::class, 'destroy'])->name('accounts.destroy');

Route::get('/profile', function () {
    return view('profile', [
        'title' => 'Profile',
        'heading' => 'Profil Pengguna'
    ]);
});