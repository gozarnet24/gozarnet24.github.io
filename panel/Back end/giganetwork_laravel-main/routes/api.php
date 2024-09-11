<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginAttemptThrottle;
use App\Http\Middleware\UserHasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([LoginAttemptThrottle::class])->post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:api', 'throttle:10,1'])->group(function () {
    Route::get('me', [UserController::class, 'index']);
    Route::get('check-notification/{Id}', [UserController::class, 'checkNotification']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
});
