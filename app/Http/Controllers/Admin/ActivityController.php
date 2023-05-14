<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{

    //save activity
    public function postactivity(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'activityTitle' => 'required',
                'activityDesc' => 'required',
                'activityImage' => 'required',
                'date' => 'required|date_format:Y-m-d',
            ],
            [
                'activityTitle.required' => 'Please enter a title for the activity',
                'activityDesc.required' => 'Please enter a description for the activity',
                'activityImage.required' => 'Please select an image for the activity',
                'date.required' => 'Please select a date for the activity',
                'date.date_format' => 'Please enter a valid date format (YYYY-MM-DD)',
            ]
        );

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
        ];
        $save = Activity::create($data);
        if ($save) {
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
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
}
