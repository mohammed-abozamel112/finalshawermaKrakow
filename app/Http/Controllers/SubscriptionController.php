<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json(
            $subscriptions
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_email' => ['required', 'email'],
        ]);

        $subscription = new Subscription();
        $subscription->subscription_email = $request->subscription_email;
        $subscription->save();

        return response()->json($subscription, 201);
    }
}
