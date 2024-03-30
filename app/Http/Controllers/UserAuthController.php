<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MaxUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
                } else {
                    return response()->json([
                        "status" => "fail",
                        "message" => "Password is incorrect"
                    ], 403);
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
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', new MaxUsers(10)],
                'password' => ['required', 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The maximum number of users has been reached.',
            ], 422);
        }
        // check  user and make sure its type is superUser
        if (!Auth::check()) {
            // If not, return a message
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this page.'
            ], 401);
        }
        $user = Auth::user(); // get the current logged-in user

        if ($user->type !== 'superAdmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to Add users.'
            ], 403);
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
    // logout  user from application
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'User is not logged in.'
            ], 401);
        }

        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out Successfully'
        ]);
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

        $user = Auth::user(); // get the current logged-in user

        if ($user->type !== 'superAdmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to delete users.'
            ], 403);
        }

        if ($id == 1) {
            return response()->json([
                "message" => "This admin account cannot be deleted."
            ], 403);
        } else {
            try {
                $userToDelete = User::findOrFail($id);

                if ($userToDelete->id === $user->id) {
                    return response()->json([
                        "status" => false,
                        "message" => "You cannot delete your own account."
                    ], 403);
                }

                $userToDelete->delete();
                return response()->json([
                    "status" => true,
                    "message" => "User deleted Successfully."
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    "status" => false,
                    "message" => "No data found"
                ]);
            }
        }
    }
}
