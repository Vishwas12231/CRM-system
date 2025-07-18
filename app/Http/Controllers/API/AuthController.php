<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login and return a token
     */
    public function login(Request $request)
    {
        // Validate the login input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to find the user
        $user = User::where('email', $request->email)->first();

        // If user not found or password doesn't match
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create token
        $token = $user->createToken('api-token')->plainTextToken;

        // Return token with user info
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin
            ]
        ]);
    }
}
