<?php

namespace App\Http\Controllers;

use App\Helpers\Service;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Service::login($credentials['username'], $credentials['password'])) {
            $user = User::updateOrCreate(['name' => $credentials['username']], ['name' => $credentials['username']]);
            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'ورود موفقیت‌آمیز بود', 'token' => $token], 200);
        }

        return response()->json(['message' => 'اطلاعات ورود نامعتبر است'], 401);
    }
}
