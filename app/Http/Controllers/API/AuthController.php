<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
       ]);

       $data = [
            'email' => $request->email,
            'password' => $request->password,
       ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json(['message' => 'Successfully logged in', 'user' => $user->name, 'auth_token' => $token], 200);
    }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
       $request->validate([
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
       ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
       ]);

       $token = $user->createToken('auth_token')->accessToken;
       return response()->json(['user' => $user->name, 'email' => $user->email, 'auth_token' => $token], 201);
    }

    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([ 'message' => 'Successfully logged out'], 200);
    }
}
