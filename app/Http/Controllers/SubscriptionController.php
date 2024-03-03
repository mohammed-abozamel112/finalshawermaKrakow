<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        try {
            $subscriptions = Subscription::all();
            return response()->json(
                $subscriptions
            );
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Error occurred: " . $e->getMessage()
            ]);
        }

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
