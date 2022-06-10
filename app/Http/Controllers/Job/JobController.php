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
     public function getJobsInfo(Request $request){
 
         if ($request->lang === "1"){
            $job = Job::all('id', 'en_title','academy_id', 'job_type_id', 'en_advertise_area','en_hiring_budget', 'job_level_id','gender_id', 'job_vacancy','en_job_description', 'expected_start_date', 'job_deadline','en_job_responsibilities', 'en_job_benefits', 'en_job_experience','ar_job_experience')->append('AcademiesInfo');
            return $this->onSuccess($job);
         }
         if ($request->lang === "2"){
            $job = Job::all('id', 'ar_title','academy_id', 'job_type_id', 'ar_advertise_area','ar_hiring_budget', 'job_level_id','gender_id','ar_job_description', 'expected_start_date', 'job_deadline','ar_job_responsibilities', 'en_job_benefits', 'ar_job_experience','ar_job_experience')->append('AcademiesInfo');
         }
         else{
            return $this->onSuccess('Invild Input');
            
         }
        }
}
