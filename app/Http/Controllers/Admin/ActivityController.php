<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Validation\ValidationController;
use App\Models\UserMainActivity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{

    //save activity
    public function postactivity(Request $request, ValidationController $validationController)
    {
      
        $validator = $validationController->validateActivity($request);
         if ($validator->fails()) {
            return response()->json($validator->errors()->first(),400);
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
        ];
        $save = Activity::create($data);
        if ($save) {
            //adding each activity for each user
            $users = User::where('role', '!=', 1)->get();
            foreach ($users as $user) {
                $data = [
                    'user_id' => $user['id'],
                    'activity_id' => $save->id,
                ];
                UserActivity::create($data);
            }

            return response()->json(['success' => true, 'data' => $save], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }

    //fetch activity
    public function getactivity(Request $request)
    {
        $start =  $request->start;
        $end =  $request->end;
        $activities = Activity::whereBetween('date', [$start, $end])->get();

        $formattedActivities = [];

        foreach ($activities as $activity) {
            $formattedActivities[] = [
                'id' => $activity->id,
                'title' => $activity->title,
                'desc' => $activity->description,
                'image' => $activity->image,
                'start' => $activity->date,
                'allDay' => true,
            ];
        }
        return response()->json($formattedActivities);
    }

    //update activity 
    public function editactivity(Request $request, $id)
    {

        $activity = Activity::find($id);
        if ($request->hasFile('image')) {
            $path = 'Images/activity/' . $activity->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('Images/activity/', $filename);
            $activity->image = $filename;
        }

        $activity->title =  $request->editActivityTitle;
        $activity->description = $request->editActivityDesc;
        $update = $activity->save();
        if ($update) {
            return response()->json(['success' => true, 'data' => $activity], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }

    //delete activity
    public function deleteactivity($id)
    {
        $activity = Activity::find($id);
        if ($activity->image) {
            $path = 'Images/activity/' . $activity->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $deleted =  $activity->delete();
        if ($deleted) {
            UserActivity::where('activity_id', $id)->delete();
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }


    //get activities for users by dates differences
    public function getActivities(Request $request)
    {
        // Get the logged-in user
        $user = Auth::user()->id;
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        $activitiesData = [];
        $activitiesData['userActivities'] = UserMainActivity::where('user_id', $user)->whereBetween('date', [$start, $end])->get();
        $GlobalAct = UserActivity::where('user_id', $user)
            ->with(['activity' => function ($query) use ($start, $end) {
                $query->whereBetween('date', [$start, $end]);
            }])
            ->get();

        foreach ($GlobalAct as $glo) {
            if ($glo->activity != null) {
                $activitiesData['globalActivities'][] = $glo->activity;
            }
        }

        return response()->json([
            'status' => 201,
            'activities' => $activitiesData,
        ], 201);
    }
}
