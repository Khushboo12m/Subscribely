<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
        protected function redirectTo($request)
    {
        // Return JSON response for API routes instead of redirecting
        if ($request->expectsJson() || $request->is('api/*')) {
            abort(response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please provide a valid token.'
            ], 401));
        }

        // For web routes (optional)
        return route('login');
    }
}
