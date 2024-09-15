<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        $token = $user->createToken("myapptoken")->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|',
            'password' => 'required|string|',
        ]);

        // Check email
        $user = User::where('email', $request->email)
            ->first();

        // Check password
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken("myapptoken")->plainTextToken;
        } else {
            return response()->json(["message" => "User does not exist"], 401);
        }
        $response = [
            "user" => $user,
            "token" => $token,
            "message" => "Login Successful."
        ];

        return response()->json($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
