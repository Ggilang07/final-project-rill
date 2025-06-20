<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role user
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->with('error', 'Akses ditolak: Jenis akun tidak sesuai dengan halaman login ini');
            }

            return redirect()->intended('/'); // rute tujuan
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log out user dari sistem

        $request->session()->invalidate(); // Hapus semua session data
        $request->session()->regenerateToken(); // Regenerasi CSRF token baru (keamanan)

        return redirect('/login')->with('status', 'Berhasil logout.');
    }
}
