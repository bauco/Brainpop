<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignUpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function signup(SignUpRequest $request)
    {
        error_log("signup");
        $credentials = $request->only('email', 'password','name');
        $validated = $request->validated();
        error_log("validated pass");
        error_log($request->input('name'));
        error_log($request->input('email'));
        error_log($request->input('password'));
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        error_log("user");
        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User signup successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

}
