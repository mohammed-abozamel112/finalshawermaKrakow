<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        try {
            if ($user = User::firstWhere('email', $request->email)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('user')->plainTextToken;
                    $user->tokens()->create([
                        'name' => 'Admin',
                        'token' => $token,
                    ]);
                    return response()->json([
                        'status' => 'logged',
                        'token' => $token,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email or password not valid'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User has been created successfully.'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}
