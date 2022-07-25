<?php

namespace App\Http\Controllers\Job;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobActApply;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\SendStatusUpdate;
use App\Mail\AppMail;
use App\Models\Teachers\Teacher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
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

      $userId = Auth::id();
      $job = Job::select(['jobs.*', 'job_act_apply.created_at as applied_on', 'job_act_apply.status as applied_status'])->leftJoin('job_act_apply', function ($join) use ($userId) {
         $join->on('jobs.id', 'job_act_apply.job_id')->where('job_act_apply.teacher_id', $userId);
      })->where('jobs.status', 1)->whereNull('deleted_at')->get()->load('academy', 'level', 'type', 'subjects');
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
         'edu_level_id' => 'required',
         'min_exp_id' => 'required',
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
         $job = Job::where('id', $request->id)->whereNull('deleted_at')->where('academy_id', $academy->id)->first();
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
      $jobData = Job::with(['academy', 'level', 'type', 'subjects'])->where('id', $job->id)->first();
      return $this->onSuccess($jobData);
   }

   public function get_my_jobs(Request $request)
   {
      $academy = Academy::where('user_id', Auth::id())->first();
      $data = Job::with(['academy', 'level', 'type', 'subjects'])->withCount(['applications', 'awaiting', 'reviewed', 'contacting', 'rejected'])->where("academy_id", $academy->id)->whereNull('deleted_at')->paginate();
      return $this->onSuccess($data);
   }
   public function get_available_jobs(Request $request)
   {
      $data = Job::where('status', 1)->whereNull("deleted_at")->paginate(20);
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
      $job = Job::where('academy_id', $academy->id)->where('country', $request->country)->where('state', $request->state)->whereNull('deleted_at');
      if (isset($request->language)) {
         $job = $job->where('language', $request->language);
      }
      if (isset($request->title)) {
         $job = $job->where('title', $request->title);
      }
      if (isset($request->edu_level_id)) {
         $job = $job->where('edu_level_id', $request->edu_level_id);
      }
      if (isset($request->job_subject_id)) {
         $job = $job->where('job_subject_id', $request->job_subject_id);
      }
      $job = $job->with(['academy', 'level', 'type', 'subjects'])->first();
      return $this->onSuccess([
         'job' => $job,
         'academy' => $academy
      ]);
   }

   public function getAllApplications(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'status' => ['nullable', Rule::in([0, 1, 2, 3, 4]),],
      ]);
      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError(["No Academy Found"]);
      }
      $jobApply = JobActApply::where('academy_id', $academy->id)->with(['academy', 'jobs']);
      if (isset($request->status)) {
         $jobApply = $jobApply->where('status', $request->status);
      }
      $jobApply = $jobApply->paginate();
      return  $this->onSuccess($jobApply, 200, "success");
   }

   public function applicationStatus(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'id' => 'required',
         'status' => ['required', Rule::in([1, 2, 3, 4]),],
      ], [], [
         "id" => "Apply ID"
      ]);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $user = User::find(Auth::id());
      return $user->email;
      if ($user->is_active != 1 || $user->email_verified_at == NULL) {
         return $this->onError("Account is not verified", 400);
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError(["No Academy Found"]);
      }

      $applyStatus = JobActApply::where('id', $request->id)->where('academy_id', Auth::id())->first();
      if (!$applyStatus) {
         return $this->onError(["No Application Found"]);
      }
      $applyStatus->status = $request->status;
      $applyStatus->save();
      $teacher = Teacher::find($applyStatus->teacher_id);
      if ($teacher) {
         $teacherUser = User::find($teacher->user_id);

         Mail::to($teacherUser->email)->send(new SendStatusUpdate($request->all()));
      }

      return $this->onSuccess($applyStatus, 200, "Status updated successfully");
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

      $jobStatus = Job::where('id', $request->id)->whereNull('deleted_at')->where('academy_id', $academy->id)->first();
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
      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
   }
   public function pauseAJob(Job $job): Job
   {
      $job->status = 2;
      $job->save();
      $jobData =  $job::with(['academy', 'level', 'type'])->first();
      return $jobData;
   }
   public function activeAJob(Job $job): Job
   {
      $job->status = 1;
      $job->save();
      $jobData =  $job::with(['academy', 'level', 'type'])->first();
      return $jobData;
   }
   public function finishAJob(Job $job): Job
   {
      $job->status = 5;
      $job->save();
      $jobData =  $job::with(['academy', 'level', 'type'])->first();
      return $jobData;
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
      if ($user->user_type == 255) {
         return $this->onError(["Only teacher can apply for this job"]);
      }
      $jobStatus = Job::where('id', $request->id)->whereNull('deleted_at')->first();
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
      $apply->teacher_id = $user->id;
      $apply->job_id = $jobStatus->id;
      $apply->academy_id = $jobStatus->academy_id;
      $apply->apply_date = Carbon::now();
      $apply->status = 0;
      $apply->save();

      return $this->onSuccess([
         'user' => $user,
         'job' => $jobStatus,
         'apply' => $apply
      ], 200, "Applied Successfully");
   }
   public function deleteJob(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'id' => 'required',
      ], [], [
         "id" => "Job ID"
      ]);

      if ($validator->fails()) {
         return $this->onError($validator->errors()->all());
      }
      $academy = Academy::where('user_id', Auth::id())->first();
      if (!$academy) {
         return $this->onError(["No Academy Found"]);
      }
      $deleteJob = Job::where('id', $request->id)->where('academy_id', $academy->id)->with(['academy', 'level', 'type'])->first();
      if (!$deleteJob) {
         return $this->onError(["No Job Found"]);
      }
      $deleteJob->deleted_at = Carbon::now();
      $deleteJob->save();
      return $this->onSuccess($deleteJob, 200, "Job deleted successfully");
   }
   public function activateAJob(Request $request)
   {
      return Job::where('id', $request->id)->update(['status' => 1]);
   }
}
