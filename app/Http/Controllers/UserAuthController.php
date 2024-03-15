<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    // show all users
    public function showuser()
    {
        $users = User::all();
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Users fetched successfully.',
                'users' => $users
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'server_error'], 500);
        }
    }
    //login  user
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
                    $name = User::where(["id" => $user['id']])->value("name");
                    return response()->json([
                        'status' => 'logged',
                        'token' => $token,
                        'name' => $name,
                    ], 201);
                }else{
                    return response()->json([
                        "status"=>"fail",
                        "message"=>"Password is incorrect"],403);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email not valid'
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
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
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

    // delete user  by id
    public function destroy($id)
    {
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        if ($id == 1) {
            return response()->json([
                "message" => "This admin account cannot be deleted."
            ], 403);
        } else {
            try {
                $user = User::findOrFail($id);

                $user->delete();
                return response()->json([
                    "status" => true,
                    "message" => "User deleted Successfully."
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    "status" => false,
                    "Message" => "No data found"
                ]);
            }
        }
    }
}
