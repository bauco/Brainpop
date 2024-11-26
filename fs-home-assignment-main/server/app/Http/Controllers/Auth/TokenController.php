<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class TokenController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * Sample Request Payload:
     * {
     *     'email': 'test@example.com',
     *     'password': 'password'
     * }
     * Sample Success Response (200):
     * {
     *     'access_token': 'TOKEN',
     *     'token_type': 'Bearer'
     * }
     * Sample Failed Response (401):
     * {
     *     'message': 'Invalid login details'
     * }
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $validated = $request->validated();

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }
        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;
        error_log($token);
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
