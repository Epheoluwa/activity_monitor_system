<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages/login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('/')->with('success', 'Login successful');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function LoginUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required | min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401); 
        }
        
        $credentials = $request->only('email', 'password');
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            // Generate an access token for the user
            $token = $user->createToken('api')->plainTextToken;

            // Return the user data and access token
            return response()->json([
                'status' => 201,
                'Message' => 'Logged in successfully',
                'user' => $user,
                'token' => $token,
            ], 201);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
