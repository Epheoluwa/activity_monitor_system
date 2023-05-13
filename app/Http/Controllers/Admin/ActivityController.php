<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
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
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
}
