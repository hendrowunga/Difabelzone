<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UserLoginRequest;
use App\Models\User;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;

class Logincontroller extends Controller
{
    public function login(UserLoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return ApiResponse::error(
                    'Invalid credentials',
                    401
                );
            }

            $user = User::where('email', $request->email)->first();

            if (!$user->isUser()) {
                return ApiResponse::error(
                    'Unauthorized access',
                    403
                );
            }

            $token = $user->createToken('user-token')->plainTextToken;

            return ApiResponse::success([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Login successful', 200);
        } catch (\Exception $e) {
            return ApiResponse::error(
                'Login failed: ' . $e->getMessage(),
                500
            );
        }
    }
}