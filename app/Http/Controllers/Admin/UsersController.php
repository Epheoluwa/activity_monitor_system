<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Validation\ValidationController;
use App\Models\UserMainActivity;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('pages.users', compact('users'));
    }

    public function usersActivity($id)
    {
        // $activity = UserActivity::select('id')->where('user_id', $id)->with('activity')->get();
        // var_dump($activity);
        // exit;
        $user_id = ['user_id' => $id];
        return view('pages.activities', $user_id);
    }

    public function usersActivityPost(Request $request)
    {
        $validationController = new ValidationController();
        $validator = $validationController->validateActivity($request);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('activityImage')) {
            $file = $request->file('activityImage');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('Images/activity', $filename);
            $imagename =  $filename;
        }


        $data = [
            'title' => $request->activityTitle,
            'description' => $request->activityDesc,
            'date' => $request->date,
            'image' => $imagename,
            'user_id' => $request->user_id,
        ];
        $save = UserMainActivity::create($data);
        if ($save) {
            return back()->with('success', 'User Activity Added successful');
        }else{
            return back()->with('error', 'Error While creating a new User Activity');
        }
    }
}
