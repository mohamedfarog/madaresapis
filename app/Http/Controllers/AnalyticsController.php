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

use function GuzzleHttp\Promise\all;

class AnalyticsController extends Controller
{
    public function getApplicationStats(Request $request)
    { 
        $userId = Auth::id();
        $userType = User::findOrFail($userId);
        // $academyId = Academy::where('user_id', $userId)->first()->id;
        $academyId = 18;
        $dailyStats = [];
        $weeklyStats = [];
        $monthlyStats = [];
                for ($i = 7; $i > 0; $i--) {
                    $today = Carbon::now();
                    $date = $today->subDays($i);
                    $jobs = JobActApply::where('academy_id', $academyId)->whereDate('created_at', $date);
                    $applicationsReceived = $jobs->count();
                    $applicationsPending = $jobs->where('status', 1)->count();
                    $applicationsViewed = $jobs->where('status', 2)->count();
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
                    $applicationsContacted = $jobs->where('status', 2)->count();
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
                    $applicationsContacted = $jobs->where('status', 2)->count();
                    $applicationsRejected = $jobs->where('status', 4)->count();
                    array_push($monthlyStats, ['received_applications' => $applicationsReceived, 'rejected_applications' => $applicationsRejected, 'pending_applications' => $applicationsPending, 'from_day' => $fromDate, 'to_day'=>$toDate]);
                }

                $all_application = JobActApply::where('academy_id', $academyId)->count();
                $applied = JobActApply::where('academy_id', $academyId)->where('status', 0)->count(); 
                $panndingApplications = JobActApply::where('academy_id', $academyId)->where('status', 1)->count();  
                $viewedApplications = JobActApply::where('academy_id', $academyId)->where('status', 2)->count();
                $shortListed = JobActApply::where('academy_id', $academyId)->where('status', 3)->count();
                $rejectedApplications = JobActApply::where('academy_id', $academyId)->where('status', 4)->count();
                $contactedApplication = JobActApply::where('academy_id', $academyId)->where('status', 5)->count();
                $interviewdApplication = JobActApply::where('academy_id', $academyId)->where('status', 6)->count();
                $on_holed = JobActApply::where('academy_id', $academyId)->where('status', 7)->count();
                $accepted = JobActApply::where('academy_id', $academyId)->where('status', 8)->count();
                return $this->onSuccess(['daily'=>$dailyStats,'monthly'=>$monthlyStats,'weekly'=>$weeklyStats, 'applied'=>$applied, 'all_application'=>$all_application, 'pending'=>$panndingApplications, 'viewed'=>$viewedApplications, 'shortListed'=>$shortListed, 'rejected'=> $rejectedApplications,'contacted'=>$contactedApplication, 'interviewed'=>$interviewdApplication, 'on_hold'=>$on_holed, 'accepted'=>$accepted]);
            }
        }
