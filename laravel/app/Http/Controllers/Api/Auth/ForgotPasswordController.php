<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar di sistem kami.'
                ], 404);
            }

            $otp = rand(100000, 999999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5), // OTP berlaku selama 5 menit
            ]);

            Mail::to($user->email)->send(new SendOtpMail($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP telah dikirim ke email Anda.',
                'email' => $user->email // Return email for subsequent requests
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar.'
            ], 404);
        }

        if ($user->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah.'
            ], 422);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kedaluwarsa.'
            ], 422);
        }

        // Generate a password reset token (optional but recommended for security)
        $resetToken = Str::random(64);
        $user->update([
            'reset_token' => $resetToken,
            'reset_token_expires_at' => now()->addMinutes(30)
        ]);
        \Log::info('Reset token after update:', [$user->reset_token]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil diverifikasi.',
            'reset_token' => $resetToken
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_token' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_token', $request->reset_token)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token reset tidak valid.'
            ], 422);
        }

        if (now()->greaterThan($user->reset_token_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Token reset sudah kedaluwarsa.'
            ], 422);
        }

        // Check if new password same as old password
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password baru tidak boleh sama dengan password lama.'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.'
        ]);
    }
}
