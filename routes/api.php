<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\Logincontroller as AdminLoginController;
use App\Http\Controllers\Admin\Auth\Logoutcontroller as AdminLogoutController;
use App\Http\Controllers\User\Auth\Logincontroller as UserLoginController;
use App\Http\Controllers\User\Auth\Logoutcontroller as UserLogoutController;
use App\Http\Controllers\User\Auth\Registercontroller as UserRegisterController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/register', [UserRegisterController::class, 'register']);
        Route::post('/login', [UserLoginController::class, 'login']);
        Route::post('/logout', [UserLogoutController::class, 'logout'])
            ->middleware('auth:sanctum');
    });

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::post('/login', [AdminLoginController::class, 'login']);
        Route::post('/logout', [AdminLogoutController::class, 'logout'])
            ->middleware('auth:sanctum');
    });
});