<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Jobs\Job;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
   /**
    * Handle the incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function getJobsInfo(Request $request)
   {

      if ($request->lang === "1") {
         $job = Job::all('id', 'en_title', 'academy_id', 'job_type_id', 'en_advertise_area', 'en_hiring_budget', 'job_level_id', 'gender_id', 'job_vacancy', 'en_job_description', 'expected_start_date', 'job_deadline', 'en_job_responsibilities', 'en_job_benefits', 'en_job_experience', 'ar_job_experience')->append('AcademiesInfo');
         return $this->onSuccess($job);
      }
      if ($request->lang === "2") {
         $job = Job::all('id', 'ar_title', 'academy_id', 'job_type_id', 'ar_advertise_area', 'ar_hiring_budget', 'job_level_id', 'gender_id', 'ar_job_description', 'expected_start_date', 'job_deadline', 'ar_job_responsibilities', 'en_job_benefits', 'ar_job_experience', 'ar_job_experience')->append('AcademiesInfo');
      } else {
         return $this->onSuccess('Invild Input');
      }
   }

   public function addJob(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'academy_id' => 'required',
         'job_type_id' => 'required',
         'job_level_id' => 'required',
         'en_title' => 'required',
         'ar_title' => 'required',
         'en_advertise_area' => 'required',
         'ar_advertise_area' => 'required',
         'ar_advertise_area' => 'required',
      ]);

      if ($validator->fails()) {
         return response()->json(['error' => $validator->messages()], 400);
      }
      $job = new Job();
      $job->academy_id = $request->academy_id;
      $job->job_type_id = $request->job_type_id;
      $job->job_level_id = $request->job_level_id;
      $job->en_title = $request->en_title;
      $job->ar_title = $request->ar_title;
      $job->en_advertise_area = $request->en_advertise_area;
      $job->ar_advertise_area = $request->ar_advertise_area;
      $job->job_vacancy = $request->job_vacancy;
      $job->save();
      return $this->onSuccess($jobLevel, 200, "job added successfully!");
   }
}
