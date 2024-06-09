<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Perform your authentication logic here
        // For example, checking if the provided credentials match any user record

        // For demonstration purposes, let's assume authentication is successful
        // Replace this with your actual authentication logic
        $authenticatedUser = User::where('email', $request->email)->first();

        if ($authenticatedUser && Hash::check($request->password, $authenticatedUser->password)) {
            // Authentication successful
            return response()->json(['message' => 'Login successful'], 200);
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid username or password'], 401);
    }

    public function register(Request $request)
    {
        $input = $request->all();

        User::create([
            'role' => $input['role'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        return response()->json(['status' => true, 'message' => "Registration Success"]);
    }
}
