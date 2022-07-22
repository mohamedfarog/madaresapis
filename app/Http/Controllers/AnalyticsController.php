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
        //return $academyId;

        $dailyStats = [];
        $weeklyStats = [];
        $monthlyStats = [];

            //Daily
                for ($i = 7; $i > 0; $i--) {
                    $today = Carbon::now();
                    $date = $today->subDays($i);
                    $jobs = JobActApply::where('academy_id', $academyId)->whereDate('created_at', $date);
                    $applicationsReceived = $jobs->count();
                    $applicationsPending = $jobs->where('status', 1)->count();
                    $applicationsContacted = $jobs->where('status', 3)->count();
                    $applicationsRejected = $jobs->where('status', 4)->count();
                    $dayName = $date->format('l');
                    array_push($dailyStats, ['received_applications' => $applicationsReceived, 'rejected_applications' => $applicationsRejected, 'pending_applications' => $applicationsPending, 'day' => $dayName]);
                }



                for ($i =4; $i > 0; $i--) {
                    $weekAhead= $i+1;
                    $fromDate = Carbon::now()->subWeeks($i);
                    $toDate = Carbon::now()->subWeeks($i-1);
                    $jobs = JobActApply::where('academy_id', $academyId)->whereBetween('created_at', [$fromDate,$toDate]);
                    $applicationsReceived = $jobs->count();
                    $applicationsPending = $jobs->where('status', 1)->count();
                    $applicationsContacted = $jobs->where('status', 3)->count();
                    $applicationsRejected = $jobs->where('status', 4)->count();

                    array_push($weeklyStats, ['received_applications' => $applicationsReceived, 'rejected_applications' => $applicationsRejected, 'pending_applications' => $applicationsPending, 'from_day' => $fromDate, 'to_day'=>$toDate]);
                }
                for ($i =8; $i > 0; $i--) {
                    $weekAhead= $i+1;
                    $fromDate = Carbon::now()->subMonths($i);
                    $toDate = Carbon::now()->subMonths($i-1);
                    $jobs = JobActApply::where('academy_id', $academyId)->whereBetween('created_at', [$fromDate,$toDate]);
                    $applicationsReceived = $jobs->count();
                    $applicationsPending = $jobs->where('status', 1)->count();
                    $applicationsContacted = $jobs->where('status', 3)->count();
                    $applicationsRejected = $jobs->where('status', 4)->count();
                    array_push($monthlyStats, ['received_applications' => $applicationsReceived, 'rejected_applications' => $applicationsRejected, 'pending_applications' => $applicationsPending, 'from_day' => $fromDate, 'to_day'=>$toDate]);
                }
              



        

        return $this->onSuccess(['daily'=>$dailyStats,'monthly'=>$monthlyStats,'weekly'=>$weeklyStats]);
    }
}
