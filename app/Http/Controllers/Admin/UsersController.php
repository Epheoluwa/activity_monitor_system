<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Validation\ValidationController;
use App\Models\UserMainActivity;
use Illuminate\Support\Facades\File;


class UsersController extends Controller
{

    //displaay user page
    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('pages.users', compact('users'));
    }

    //display user activity page
    public function usersActivity($id)
    {
        $activitiesData = [];
        $activitiesData['userActivities'] = UserMainActivity::where('user_id', $id)->get();
        $activitiesData['globalActivities'] = UserActivity::where('user_id', $id)->with('activity')->get();
        $user_id = ['user_id' => $id];
        return view('pages.activities',  compact('activitiesData', 'user_id'));
    }

    //Save new  user activity
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
        } else {
            return back()->with('error', 'Error While creating a new User Activity');
        }
    }


    //update user activity
    public function usersActivityEdit(Request $request, $id)
    {
        $activity = UserMainActivity::find($id);
        if ($request->hasFile('activityImage')) {
            $path = 'Images/activity/' . $activity->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('activityImage');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('Images/activity/', $filename);
            $activity->image = $filename;
        }

        $activity->title =  $request->activityTitle;
        $activity->description = $request->activityDesc;
        $activity->date = $request->activityDate;
        $update = $activity->save();
        if ($update) {
            return back()->with('success', 'User Activity Updated successful');
        } else {
            return back()->with('error', 'Error While Updating User Activity');
        }
    }


    //update user activity for global
    public function usersActivityEditGlobal(Request $request, $id)
    {
        if ($request->hasFile('activityImage')) {
            $file = $request->file('activityImage');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('Images/activity/', $filename);
            $imagename =  $filename;
        } else {
            //make a copy of the original image and save the new copy name
            $oldPath = 'Images/activity/' . $request->activityImageOld;
            $imagename = 'edit' . $request->activityImageOld;
            $newPath = 'Images/activity/' . $imagename;
            File::copy($oldPath, $newPath);
        }

        $data = [
            'title' => $request->activityTitle,
            'description' => $request->activityDesc,
            'date' => $request->activityDate,
            'image' => $imagename,
            'user_id' => $request->user_id,
        ];
        $update = UserMainActivity::create($data);
        if ($update) {
            UserActivity::where('activity_id', $id)->where('user_id', $request->user_id)->delete();
            return back()->with('success', 'User Activity Updated successful');
        } else {
            return back()->with('error', 'Error While Updating User Activity');
        }
    }

    //delete user activity
    public function deleteUserActivity($id)
    {
        $activity = UserMainActivity::find($id);
        if ($activity->image) {
            $path = 'Images/activity/' . $activity->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        try {
            $activity->delete();
            return back()->with('success', 'User Activity Deleted successful');
        } catch (\Exception $e) {
            return back()->with('error', 'Error While Deleting User Activity');
        }
    }

    //delete user global activity
    public function deleteUserActivityGlobal(Request $request, $id)
    {


        try {
             UserActivity::where('activity_id', $id)->where('user_id', $request->user_id)->delete();
            return back()->with('success', ' Activity Deleted for this User Successful');
        } catch (\Exception $e) {
            return back()->with('error', 'Error While Deleting User Activity');
        }
    }
}
