<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Step 1: Send OTP
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['message' => 'Email not found'], 404);
        }

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
        );

        // Send OTP on email
        Mail::raw("Your OTP is: $otp", function ($msg) use ($request) {
            $msg->to($request->email)->subject('Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent to your email']);
    }

    // Step 2: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $otpData = PasswordOtp::where('email', $request->email)->first();

        if(!$otpData){
            return response()->json(['message' => 'OTP not found'], 404);
        }

        if($otpData->otp !== $request->otp){
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if(now()->greaterThan($otpData->expires_at)){
            return response()->json(['message' => 'OTP expired'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully']);
    }

    // Step 3: Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $otpData = PasswordOtp::where('email', $request->email)->first();

        if(!$otpData || $otpData->otp !== $request->otp){
            return response()->json(['message' => 'Invalid or missing OTP'], 400);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // OTP delete after success
        $otpData->delete();

        return response()->json(['message' => 'Password reset successful']);
    }
}
