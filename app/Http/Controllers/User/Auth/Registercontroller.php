<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UserLoginRequest;
use App\Http\Requests\User\Auth\UserRegisterRequest;
use App\Models\User;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

class Registercontroller extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        try {
            $userId = (string) Str::uuid(); // Generate UUID
            Log::info('Generated User ID: ' . $userId);

            $user = User::create([
                'user_id' => $userId,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_USER
            ]);

            $token = $user->createToken('user-token')->plainTextToken;

            return ApiResponse::success([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Registration successful', 201);
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return ApiResponse::error(
                'Registration failed: ' . $e->getMessage(),
                500
            );
        }
    }
}