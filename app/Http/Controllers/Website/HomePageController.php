<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use App\Models\Jobs\JobLevel;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobType;
use App\Models\Skills;
use Illuminate\Http\JsonResponse;
use App\Models\Website\HomeBanner;
use Illuminate\Http\Request;
use App\Models\Website\Articles;
use App\Models\Website\QuestionedAnswers;
use App\Models\Website\subjects;
use Illuminate\Support\Js;
use JWTAuth;

class HomePageController extends Controller
{

    // protected $user;

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function getHomeBanner(): JsonResponse
    {
       
 
            $banner = HomeBanner::all();
            return $this->onSuccess($banner);
   
    }
    public function getArticaleInfo(): JsonResponse
    {

            $articleInfo = Articles::all('id', 'title', 'owner_name', 'published_date', 'body');
            return $this->onSuccess($articleInfo);
    
    }
    public function getSubjectsTitle(): JsonResponse
    {
       
            $title = subjects::all('id', 'title', 'icon')->append('count')->toArray();
            return $this->onSuccess($title);
      
    }
    public function returnJobLevel(): JsonResponse
    {
  
            $jobLevel = JobLevel::all('id', 'title', 'avater');
            return $this->onSuccess($jobLevel);
     
    }
    public function getFaqInfo()
    {


     
            $faq = QuestionedAnswers::all('id', 'title', 'body');
            return $this->onSuccess($faq);
     
    }


    public function AvailableJobs()
    {
        
            $jobs = Academy::get(['id', 'name', 'avatar', 'banner', 'bio'])
                ->append(['totaljobs', 'vacancies'])->toArray();
            return $this->onSuccess($jobs);
   
    }
    public function homePageBanner()
    {
      
            $banner = HomeBanner::all('id', 'avatar', 'text');
            return $this->onSuccess($banner);

    }

    public function userSkills(){
        $skill = Skills::all();
        return $this->onSuccess($skill);
    }



    public function testJwt()
    {
        return $this->user;
    }
}
