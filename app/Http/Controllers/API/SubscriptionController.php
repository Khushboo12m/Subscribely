<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // List all subscriptions
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => true,
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Add a new subscription
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'billing_cycle' => 'required|string',
            'next_renewal_date' => 'required|date',
            'notification_email' => 'nullable|email',
        ]);

        $validated['user_id'] = Auth::id(); 

        $subscription = Subscription::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Subscription added successfully',
            'data' => $subscription
        ]);
    }

    /**
     * Display the specified resource.
     */
    // View a single subscription
    public function show($id)
    {
        $subscription = Subscription::where('user_id', Auth::id())->find($id);

        if (!$subscription) {
            return response()->json(['status' => false, 'message' => 'Subscription not found'], 404);
        }

        return response()->json(['status' => true, 'subscription' => $subscription]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Update a subscription
        public function update(Request $request, $id)
    {
        $subscription = Subscription::where('user_id', Auth::id())->find($id);

        if (!$subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription not found'
            ], 404);
        }

        $subscription->update([
            'service_name' => $request->service_name,
            'amount' => $request->amount,
            'billing_cycle' => $request->billing_cycle,
            'next_renewal_date' => $request->next_renewal_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subscription updated successfully',
            'data' => $subscription
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
   // Delete a subscription
    public function destroy($id)
    {
        $subscription = Subscription::where('user_id', Auth::id())->find($id);

        if (!$subscription) {
            return response()->json(['status' => false, 'message' => 'Subscription not found'], 404);
        }

        $subscription->delete();

        return response()->json(['status' => true, 'message' => 'Subscription deleted successfully']);
    }
}
