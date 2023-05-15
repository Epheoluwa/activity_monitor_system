<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    public function validateActivity(Request $request)
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

        return $validator;
    }
}
