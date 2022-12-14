<?php
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use App\Models\Jobs\JobLevel;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobType;
use App\Models\Skills;
use App\Models\Skill;
use App\Models\Test;
use App\Models\Available;
use Illuminate\Http\JsonResponse;
use App\Models\Website\HomeBanner;
use Illuminate\Http\Request;
use App\Models\Website\Articles;
use App\Models\Website\QuestionedAnswers;
use App\Models\Website\subjects;
use App\Models\Website\JobsType;
use Illuminate\Support\Js;

use JWTAuth;

class HomePageController extends Controller
{
        //protected $user;
        //public function __construct()
        // {
                //     $this->user = JWTAuth::parseToken()->authenticate();
                // }
                /**
                 * * Handle the incoming request.
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
        $banner = HomeBanner::all();return $this->onSuccess($banner);

    }


    public function getArticaleInfo(Request $request): JsonResponse
    {
        if($request->lang == 1){
                $articleInfo = Articles::all('id', 'ar_title', 'ar_owner_name', 'published_date', 'ar_body');
                return $this->onSuccess($articleInfo);

        }
        else{
                $articleInfo = Articles::all('id', 'title', 'owner_name', 'published_date', 'body');
                return $this->onSuccess($articleInfo);
        }
}
public function getJobType(Request $request){
        if($request->lang == '1'){
               return $this->onSuccess($jobsType = JobsType::all('id', 'type_ar_name'));
        }
        else{
             return $this->onSuccess($jobsType = JobsType::all('id', 'type_en_name'));
}
}

    public function getSubjectsTitle(): JsonResponse
    {
        $title = subjects::all('id', 'title', 'icon')->append('count')->toArray();
        return $this->onSuccess($title);

    }

    public function returnJobLevel(Request $request): JsonResponse
    {
        if($request->lang == '1'){
                $jobLevel = JobLevel::all('id', 'ar_title', 'avater');
                return $this->onSuccess($jobLevel);
        }
        else{
                $jobLevel = JobLevel::all('id', 'title', 'avater');
                return $this->onSuccess($jobLevel);
        }
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

public function homePageBanner(Request $request)
{
        if($request->lang == 1){
                $banner = HomeBanner::all('id', 'avatar', 'ar_text');
                return $this->onSuccess($banner);

        }
        else{
                $banner = HomeBanner::all('id', 'avatar', 'text');
                return $this->onSuccess($banner);
        }
}

    public function gteAllJobs(){
//        $jobs = Job::with('academy', 'level', 'type', 'subjects', 'gender', 'jobMinimumExperience', 'salaryRate')
        $jobs = Job::with('academy', 'level', 'type', 'subjects', 'jobMinimumExperience', 'salaryRate')
            ->where('status', 1)->whereNull('deleted_at')->get();
        return $this->onSuccess($jobs);
    }

public function userSkills(Request $request)
{
        if($request->lang == 1){
                $skill = Skill::all('id', 'ar_skill_name');
                return $this->onSuccess($skill);

        }

        else{
                $skill = Skill::all('id', 'en_skill_name');
                return $this->onSuccess($skill);
        }
}
    public function AvailableApplicant(Request $request)
    {
        if($request->lang == 1){
                $availabe = Available::all('id', 'ar_text');
                return $this->onSuccess($availabe);
        }
        else{
                $availabe = Available::all('id', 'en_text');
                return $this->onSuccess($availabe);
        }

}

    public function testJwt()
    {
        return $this->user;
    }

    public function testingHtttpRequest(Request $request){
        return $request->age;
        $test  = new Test();
        $test->name = $request->name;
        $test->age = $request->age;
        $test->occupation = $request->occ;
        $test->save();
        return $test;
        return  $this->onSuccess($request);

    }
}

