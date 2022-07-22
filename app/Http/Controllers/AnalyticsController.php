<?php

namespace App\Http\Controllers;

use App\Models\Academies\Academy;
use App\Models\Jobs\JobActApply;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnalyticsController extends Controller
{
    // Profile Viewed-

    public function getApplicationStats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'datesType' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }
        $userId = Auth::id();


        $userType = User::findOrFail($userId);
        $academyId = Academy::where('user_id', $userId)->first()->id;

        $dataArray = [];
        switch ($request->datesType) {
            case 'daily':
                for ($i = 7; $i > 0; $i--) {
                    $today = Carbon::now();
                    $date = $today->subDays($i);
                    $jobs = JobActApply::where('academy_id', $academyId)->whereDate('created_at', $date);
                    $applicationsReceived = $jobs->get();
                    $applicationsPending = $jobs->where('status', 1)->get();

                    $applicationsContacted = $jobs->where('status', 3)->get();
                    $applicationsRejected = $jobs->where('status', 4)->get();
                    $dayName = $date->format('l');
                    array_push($dataArray, ['received_applications' => $applicationsReceived, 'rejected_applications' => $applicationsRejected, 'pending_applications' => $applicationsPending, 'day' => $dayName]);
                }


            case 'weekly':
            case 'monthly':
        }
        return $this->onSuccess($dataArray);
    }
}
