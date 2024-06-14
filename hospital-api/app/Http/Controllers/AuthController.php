<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
                    'id' => $user->id,
                    'role' => $user->role,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
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

    public function getAllUsers()
    {
        $users = User::excludeRole('admin')->get();
        return response()->json(['users' => $users], 200);
    }

    public function getUser($id)
    {
        $user = User::whereNotIn('role', ['admin', 'doctor'])->find($id);
        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function getAllDoctors()
    {
        $users = User::where('role', 'Doctor')->get();
        return response()->json(['users' => $users], 200);
    }

    public function getDoctor($id)
    {
        $user = User::whereNotIn('role', ['admin', 'patient'])->find($id);
        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $input = $request->all();
        $user->role = $input['role'];
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
