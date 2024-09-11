<?php

namespace App\Http\Controllers;

use App\Helpers\Service;
use App\Http\Resources\CardInfoResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PlansResource;
use App\Models\Config;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $username = auth()->user()->name;
        $information = Service::information($username);
        $plans = Plan::all();
        $cartInfo = Config::where('key', 'card')->first() ?? null;
        return response()->json(['success' => true, 'data' => [
            'username' => $username,
            'service_information' => $information,
            'notifications' => NotificationResource::collection(
                Notification::whereHas('users', function ($query) {
                    $query->whereNot('user_id', auth()->id());
                })->get()
            ),
            'plans' => PlansResource::collection($plans),
            'card_info' => $cartInfo

        ]]);
    }

    public function checkNotification(Request $request, Notification $Id)
    {
        if (is_null($Id)) {
            return response()->json(['success' => false, 'message' => 'ID not found'], 400);
        }

        UserNotification::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'notification_id' => $Id->id
            ],
            [
                'notification_id' => $Id->id
            ]
        );

        return response()->json(['success' => true, 'message' => 'Your request was successful.']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:4|max:15'
        ], [
            'password.required' => 'رمزعبور الزامی است.',
            'password.string' => 'رمزعبور باید شامل حروف باشد.',
            'password.min' => 'رمزعبور باید حداقل 4 کاراکتر باشد.',
            'password.max' => 'رمزعبور باید حداکثر 15 کاراکتر باشد.'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
        }

        $password = Service::resetPassword(auth()->user()->name, request('password'));
        return $password ? response()->json(['success' => true, 'message' => 'Your request was successful.']) :  response()->json(['success' => false, 'message' => 'Failed']);
    }
}
