<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak terdaftar di sistem kami.']);
            }

            $otp = rand(100000, 999999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5), // OTP berlaku selama .. menit
            ]);

            Mail::to($user->email)->send(new SendOtpMail($otp)); // ganti queue() dengan send() untuk testing

            session(['reset_email' => $user->email]);
            
            return redirect('/verify-otp')->with('success', 'OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim OTP: ' . $e->getMessage()]);
        }
    }


    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $user = User::where('email', session('reset_email'))->first();

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP salah atau kedaluwarsa.']);
        }

        session(['verified_otp' => true]);
        return redirect('/reset-password');
    }

    public function showResetForm()
    {
        if (!session('verified_otp')) {
            return redirect('/forgot-password');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('email', session('reset_email'))->first();

        // Check if new password same as old password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        // Check if password matches confirmation
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password_confirmation' => 'Konfirmasi password tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        session()->forget(['reset_email', 'verified_otp']);

        return redirect('/login')->with('success', 'Password berhasil diubah.');
    }
}
