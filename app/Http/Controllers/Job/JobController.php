<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobActApply;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
         'job_subject_id' => 'required',
         'title' => 'required',
         'gender' => 'required|numeric',
         'country' => 'required|string',
         'state' => 'required|string',
         'language' => 'nullable|numeric',
         'desc' => 'required',
         'job_vacancy' => 'required',
         'close_date' => 'required|date',
         'post_date' => 'required|date',

      ], []);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $user = User::find(Auth::id());
      if ($user->is_active != 1 || $user->email_verified_at == NULL) {
         return $this->onError("Account is not verified", 400);
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError("No Academy Info Found", 400);
      }
      $job = new Job();
      if (isset($request->id)) {
         $job = Job::where('id', $request->id)->where('academy_id', $academy->id)->first();
         if (!$job) {
            return $this->onError('No Job found');
         }
      }
      $job->academy_id = $academy->id;
      $job->job_subject_id = $request->job_subject_id;
      $job->title = $request->title;
      $job->language = $request->language;
      $job->state = $request->state;
      $job->country = $request->country;
      $job->desc = $request->desc;
      $job->job_vacancy = $request->job_vacancy;
      $job->gender = $request->gender;
      $job->edu_level_id = $request->edu_level_id;
      $job->comunication_email = $request->comunication_email;
      $job->min_exp_id = $request->min_exp_id;
      $job->salary_rate_id = $request->salary_rate_id;
      $job->salary_from = $request->salary_from;
      if (isset($request->salary_to)) {
         $job->salary_to = $request->salary_to;
      }

      $job->post_date = $request->post_date;
      $job->close_date = $request->close_date;
      $job->status = 0;

      if (isset($request->custom_questions)) {
         $job->custom_questions = implode(",", $request->custom_questions);
      }


      $job->save();
      return $this->onSuccess($job, 200, "job added successfully!");
   }
   public function get_my_jobs(Request $request)
   {
      $academy = Academy::where('user_id', Auth::id())->first();

      //add q whwere deleted_at is not null
      $data = Job::where("academy_id", $academy->id && "deleted_at" !=null)->paginate();
      return $this->onSuccess($data);
   }
   public function get_available_jobs(Request $request)
   {
        //add q whwere deleted_at is not null
      $data = Job::where('status', 1 && "deleted_at"!=null)->paginate(20);
      return $this->onSuccess($data);
   }
   public function searchJobPost(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'title' => 'required',
         'country' => 'required',
         'state' => 'required',
      ]);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $user = User::find(Auth::id());
      if ($user->is_active != 1 || $user->email_verified_at == NULL) {
         return $this->onError("Account is not verified", 400);
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError(["No Academy Found"]);
      }
      $job = Job::where('academy_id', $academy->id)->where('country', $request->country)->where('state', $request->state)->where('title', $request->title);
      if (isset($request->language)) {
         $job = $job->where('language', $request->language);
      }
      $job = $job->first();
      return $this->onSuccess([
         'job' => $job,
         'academy' => $academy
      ]);
   }

   public function updateStatus(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'id' => 'required',
         'status' => ['required', Rule::in(['pause', 'active', 'finish']),],
      ], [], [
         "id" => "Job ID"
      ]);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $user = User::find(Auth::id());
      if ($user->is_active != 1 || $user->email_verified_at == NULL) {
         return $this->onError("Account is not verified", 400);
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError(["No Academy Found"]);
      }

      $jobStatus = Job::where('id', $request->id)->where('academy_id', $academy->id)->first();
      if (!$jobStatus) {
         return $this->onError(["No Job Found"]);
      }
      if ($jobStatus->status == 0 || $jobStatus->status == 3 || $jobStatus->status == 4 || $jobStatus->status == 5) {
         return $this->onError(["Action not allowed"]);
      }
      switch ($request->status) {
         case 'pause':

            if ($jobStatus->status == 1) {
               $jobStatus = $this->pauseAJob($jobStatus);
            } else {
               return $this->onError(["Action not allowed"]);
            }
            break;
         case 'active':
            if ($jobStatus->status == 2) {
               $jobStatus = $this->activeAJob($jobStatus);
            } else {
               return $this->onError(["Action not allowed"]);
            }
            break;
         case 'finish':
            if ($jobStatus->status == 2 || $jobStatus->status == 1) {
               $jobStatus = $this->finishAJob($jobStatus);
            } else {
               return $this->onError(["Action not allowed"]);
            }
            break;

         default:
            return $this->onError(["Action not allowed"]);
            break;
      }
      return $this->onSuccess($jobStatus);
   }
   public function pauseAJob(Job $job): Job
   {
      $job->status = 2;
      $job->save();
      return $job;
   }
   public function activeAJob(Job $job): Job
   {
      $job->status = 1;
      $job->save();
      return $job;
   }
   public function finishAJob(Job $job): Job
   {
      $job->status = 5;
      $job->save();
      return $job;
   }
   public function applyForJob(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'id' => 'required',
      ], [], [
         "id" => "Job ID"
      ]);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $user = User::find(Auth::id());

      $jobStatus = Job::where('id', $request->id)->first();
      if (!$jobStatus) {
         return $this->onError(["No Job Found"]);
      }
      if ($jobStatus->status != 1) {
         return $this->onError(["This Job is currently not active"]);
      }
      $apply = JobActApply::where('teacher_id', $user->id)->where('job_id', $jobStatus->id)->first();
      if ($apply) {
         return $this->onError(["You already have applied for this job"]);
      }
      $apply = new JobActApply();
      $apply->teacher_id=$user->id;
      $apply->job_id=$jobStatus->id;
      $apply->apply_date=Carbon::now();
      $apply->status=0;
      $apply->save();

      return $this->onSuccess([
         'user' => $user,
         'job' => $jobStatus,
         'apply' => $apply
      ]);
   }
}
