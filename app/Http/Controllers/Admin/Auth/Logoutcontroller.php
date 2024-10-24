<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Logoutcontroller extends Controller
{
    public function logout(Request $request)
    {
        try {
            // Delete the current token that was used for the request
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();

            return ApiResponse::success(
                null,
                'Admin logged out successfully',
                200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                'Logout failed: ' . $e->getMessage(),
                500
            );
        }
    }
}