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
    public function RegisterUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);
        if ($validate->fails()) {
            return new JsonResponse([
                'status' => 400,
                'Message' => $validate->errors()->first()
            ], 400);
        }

        $data = [
            'role' => 2,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make( $request->password),

        ];

        try {
            $save =  User::create($data);
            $token = $save->createToken('api')->plainTextToken;

            if ($save) {
                $activity = Activity::all();
                foreach ($activity as $act) {
                    $data = [
                        'user_id' => $save->id,
                        'activity_id' => $act['id'],
                    ];
                    UserActivity::create($data);
                }

                return new JsonResponse([
                    'status' => 201,
                    'Message' => 'New user created successfully',
                    'user' => $save,
                    'token' => $token,
                ], 201);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 400,
                'Message' => $e
            ], 400);
        }
    }
}
