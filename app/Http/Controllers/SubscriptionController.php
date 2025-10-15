<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // List all subscriptions
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json($subscriptions);
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

        $subscription = Subscription::create($validated);
        return response()->json(['message' => 'Subscription added successfully', 'data' => $subscription]);
    }

    /**
     * Display the specified resource.
     */
    // View a single subscription
    public function show($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }
        return response()->json($subscription);
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
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $subscription->update($request->all());
        return response()->json(['message' => 'Subscription updated successfully', 'data' => $subscription]);
    }


    /**
     * Remove the specified resource from storage.
     */
   // Delete a subscription
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
