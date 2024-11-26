<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class TokenController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();
        if ($user) {
            error_log("1");
            print_r($user);
            error_log("2");
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}
