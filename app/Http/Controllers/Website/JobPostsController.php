<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Jobs\JobPost;


class JobPostsController extends Controller
{
        /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function getJobPostsInfo(){
        $jobPost = JobPost::all();
        return $this->onSuccess($jobPost);

     }
}
