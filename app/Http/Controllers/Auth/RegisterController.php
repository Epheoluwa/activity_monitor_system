<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'status' => 422,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $userData = [
            'role' => 2,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ];

        try {
            $user = User::create($userData);
            $token = $user->createToken('api')->plainTextToken;

            if ($user) {
                $activities = Activity::all();

                foreach ($activities as $activity) {
                    $userActivityData = [
                        'user_id' => $user->id,
                        'activity_id' => $activity->id,
                    ];
                    UserActivity::create($userActivityData);
                }

                return new JsonResponse([
                    'status' => 201,
                    'message' => 'New user created successfully',
                    'user' => $user,
                    'token' => $token,
                ], 201);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 500,
                'message' => 'Error while creating user',
            ], 500);
        }
    }
}
