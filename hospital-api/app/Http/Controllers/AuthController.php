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

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'role' => $user->role,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 200);
        }

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
