<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'password' => Hash::make($request->password),

        ];
        $save =  User::create($data);
        if ($save) {
            return new JsonResponse([
                'status' => 201,
                'Message' => 'New user created successfully'
            ], 201);
        }else{
            return new JsonResponse([
                'status' => 200,
                'Message' => 'Something went wrong, Please try again'
            ], 200);
        }
       
    }
}
