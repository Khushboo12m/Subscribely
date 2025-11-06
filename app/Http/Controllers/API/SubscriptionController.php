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
        public function index(Request $request)
    {
        $query = Subscription::where('user_id', Auth::id());

        // Search by service name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('service_name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Optional: filter by billing cycle
        if ($request->has('billing_cycle') && !empty($request->billing_cycle)) {
            $query->where('billing_cycle', $request->billing_cycle);
        }

        // Optional: sort by upcoming renewal date
        if ($request->sort == 'next_renewal') {
            $query->orderBy('next_renewal_date', 'asc');
        }

        return response()->json([
            'status' => true,
            'data' => $query->latest()->paginate(10)
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
            'category' => 'nullable|string|in:' . implode(',', Subscription::categories()),
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

                // Validate input (including category from allowed list)
            $validated = $request->validate([
                'service_name' => 'required|string|max:255',
                'category' => 'nullable|string|in:' . implode(',', Subscription::categories()),
                'amount' => 'nullable|numeric',
                'billing_cycle' => 'required|string',
                'next_renewal_date' => 'required|date',
                'notification_email' => 'nullable|email',
            ]);

            // Update subscription with validated data
            $subscription->update($validated);

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
