<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Jobs\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function getJobsInfo()
   {

      $job = Job::all('id', 'title', 'academy_id', 'job_type_id', 'advertise_area', 'hiring_budget', 'job_level_id', 'job_vacancy', 'job_description', 'expected_start_date', 'job_deadline', 'job_responsibilities', 'job_benefits', 'job_experience', 'job_experience')->load('academy');
      return $this->onSuccess($job);
   }

   public function addJob(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'job_type_id' => 'required',
         'job_level_id' => 'required',
         'title' => 'required',
         'advertise_area' => 'required',
         'job_description' => 'required',
         'job_vacancy' => 'required',
      ]);

      if ($validator->fails()) {
         return response()->json(['error' => $validator->messages()], 400);
      }
      $user = User::find(Auth::id());
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError("No Academy Info Found", 400);
      }
      $job = new Job();
      $job->academy_id = $academy->id;
      $job->job_type_id = $request->job_type_id;
      $job->job_level_id = $request->job_level_id;
      $job->title = $request->title;
      $job->job_description = $request->job_description;
      $job->advertise_area = $request->advertise_area;
      $job->job_vacancy = $request->job_vacancy;
      $job->job_vacancy = $request->job_vacancy;
      if (isset($request->expected_start_date)) {

         $job->expected_start_date = $request->expected_start_date;
      } else {
         $job->expected_start_date = Carbon::now();
      }
      if (isset($request->job_deadline)) {

         $job->job_deadline = $request->job_deadline;
      } else {
         $job->job_deadline = Carbon::now();
      }
      $job->save();
      return $this->onSuccess($job, 200, "job added successfully!");
   }
}
