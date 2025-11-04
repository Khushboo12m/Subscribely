<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('frontend.subscriptions.index');
    }
}
