<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get summary: total subscriptions and total amount for logged-in user
     */
    public function summary()
    {
        $userId = auth()->id();

        $totalSubscriptions = Subscription::where('user_id', $userId)->count();
        $totalAmount = Subscription::where('user_id', $userId)->sum('amount');

        return response()->json([
            'total_subscriptions' => $totalSubscriptions,
            'total_amount' => $totalAmount
        ]);
    }

    /**
     * Get upcoming renewals within next 7 days
     */
    public function upcomingRenewals()
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $nextDays = Carbon::today()->addDays(7);

        $subscriptions = Subscription::where('user_id', $userId)
            ->whereBetween('next_renewal_date', [$today, $nextDays])
            ->get();

        return response()->json([
            'upcoming_renewals' => $subscriptions
        ]);
    }

    /**
     * Get monthly totals grouped by category
     */
    public function monthlyTotals()
    {
        $userId = auth()->id();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $totals = Subscription::where('user_id', $userId)
            ->whereYear('next_renewal_date', $year)
            ->whereMonth('next_renewal_date', $month)
            ->selectRaw('category, SUM(amount) as total_amount')
            ->groupBy('category')
            ->get();

        return response()->json([
            'monthly_totals' => $totals
        ]);
    }

    /**
     * Auto-categorize a service name (optional helper)
     */
    public static function autoCategorize($serviceName)
    {
        $serviceName = strtolower($serviceName);

        $categories = [
            'netflix' => 'Entertainment',
            'prime' => 'Entertainment',
            'gym' => 'Fitness',
            'spotify' => 'Music',
            'electricity' => 'Utility',
            'amazon' => 'Shopping',
            'youtube' => 'Entertainment',
            'hulu' => 'Entertainment',
            'disney' => 'Entertainment',
            'apple' => 'Technology'
        ];

        foreach ($categories as $key => $value) {
            if (strpos($serviceName, $key) !== false) {
                return $value;
            }
        }

        return 'Other';
    }
}
