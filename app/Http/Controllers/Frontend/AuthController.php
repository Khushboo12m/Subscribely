<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('frontend.auth.login');
    }

    public function registerPage()
    {
        return view('frontend.auth.register');
    }

    public function forgotPasswordPage()
    {
        return view('frontend.auth.forgot-password');
    }

    public function verifyOtpPage()
    {
        return view('frontend.auth.verify-otp');
    }

    public function resetPasswordPage()
    {
        return view('frontend.auth.reset-password');
    }
}
