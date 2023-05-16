<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\UserMainActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activitiesData = [];
        $activitiesData['userActivities'] = UserMainActivity::where('user_id', $user->id)->get();
        $activitiesData['globalActivities'] = UserActivity::where('user_id', $user->id)->with('activity')->get();
        return view('pages.index', compact('activitiesData'));
    }

}
