<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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

            if ($user->has2faEnabled()) {
                if ($user->validate2faCode($request->code)) {
                    $token = $user->createToken('auth_token')->accessToken;
                    return response()->json(['message' => 'Successfully logged in', 'user' => $user->name, 'auth_token' => $token], 200);
                } else {
                    return response()->json(['message' => 'Invalid verification code'], 401);
                }
            } else {
                $token = $user->createToken('auth_token')->accessToken;
                return response()->json(['message' => 'Successfully logged in', 'user' => $user->name, 'auth_token' => $token], 200);
            }
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
        ])->assignRole('user');

        $user->generate2faSecret();
        $qrCodeUrl = $user->getQRCodeGoogleUrl();
        
        $token = $user->createToken('auth_token')->accessToken;
        return response()->json(['user' => $user->name, 'email' => $user->email, 'auth_token' => $token, 'qr_code_url' => $qrCodeUrl], 201);
    }

    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([ 'message' => 'Successfully logged out'], 200);
    }
}
