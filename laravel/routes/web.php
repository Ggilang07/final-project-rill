<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::get('/letter-templates/create', function () {
    return view('letter-template.create', [
        'title' => 'Create Letter Template',
        'heading' => 'Buat Template Surat'
    ]);
});

Route::get('/letter-templates/edit', function () {
    return view('letter-template.edit', [
        'title' => 'Edit Letter Template',
        'heading' => 'Ubah Template Surat'
    ]);
});

Route::get('/letter-templates/delete', function () {
    return view('letter-template.delete', [
        'title' => 'Delete Letter Template',
        'heading' => 'Hapus Template Surat'
    ]);
});

Route::get('/letter-submission', function () {
    return view('letter-submission', [
        'title' => 'letter Submission',
        'heading' => 'Pengajuan Surat'
    ]);
});

Route::get('/accounts', function () {
    return view('register-account', [
        'title' => 'Accounts',
        'heading' => 'Akun Pengguna',
        'accounts' => User::all() // Tambahkan baris ini
    ]);
});

Route::get('/profile', function () {
    return view('profile', [
        'title' => 'Profile',
        'heading' => 'Profil Pengguna'
    ]);
});