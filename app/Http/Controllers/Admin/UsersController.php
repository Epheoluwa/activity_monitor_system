<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('pages.users', compact('users'));
    }

    public function usersActivity($id)
    {
        $activity = UserActivity::select('id')->where('user_id', $id)->with('activity')->get();
        var_dump($activity);
        exit;
        return view('pages.activities');
    }
}
