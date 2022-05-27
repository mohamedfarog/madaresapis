<?php
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\Academies\Academy;
use App\Models\Jobs\JobLevel;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobType;
use Illuminate\Http\JsonResponse;
use App\Models\Website\HomeBanner;
use Illuminate\Http\Request;
use App\Models\Website\Articles;
use App\Models\Website\QuestionedAnswers;
use App\Models\Website\subjects;
use Illuminate\Support\Js;

class HomePageController extends Controller
{
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
    public function getHomeBanner(Request $request): JsonResponse {
        if($request->lang === '1'){
            $banner = HomeBanner::all('id','avatar', 'en_text');
            return $this->onSuccess($banner);
        }
        if($request->lang === '2'){
            $banner = HomeBanner::all('id','avatar', 'ar_text');
            return $this->onSuccess($banner);
        }
    }
    public function getArticaleInfo(Request $request) : JsonResponse {
        if($request->lang === '1'){
            $articleInfo = Articles::all('id', 'en_title', 'en_owner_name', 'published_date', 'en_body');
            return $this->onSuccess($articleInfo);
        }
        if($request->lang === '2'
        ){
            $articleInfo = Articles::all('id', 'ar_title', 'ar_owner_name', 'published_date', 'ar_body');
            return $this->onSuccess($articleInfo);
        }else{
            return $this->onSuccess("Invilid, Please send 1 for English or 2 for Arabic titles");
        }
    }

    public function getSubjectsTitle(Request $request): JsonResponse{
        if ($request->lang === '1'){
            $title = subjects::all('id','en_title', 'icon')->append('count')->toArray();
            return $this->onSuccess($title);
        }
        if($request->lang === '2'){
            $title = subjects::all('id', 'ar_title', 'icon')->append('count')->toArray();
            return $this->onSuccess($title);
        }
        else{
            return $this->onSuccess("Invilid, Please send 1 for English or 2 for Arabic titles");
        }
    }
    public function returnJobLevel(Request $request): JsonResponse{
        if ($request->lang === '1'){
            $jobLevel = JobLevel::all('id','en_title', 'avater');
            return $this->onSuccess($jobLevel);
        }
        if($request->lang === '2'){
            $jobLevel = JobLevel::all('id', 'ar_title', 'avater');
            return $this->onSuccess($jobLevel);
        }
        else{
            return $this->onSuccess("Invilid, Please send 1 for English or 2 for Arabic titles");
        }
    }
    public function getFaqInfo(){
        $faq = QuestionedAnswers::all();
        return $this->onSuccess($faq);
    }
    
    public function AvailableJobs(Request $request)
    { 
        $jobs = Academy::get(['id', 'name','avatar','banner'])
        ->append(['totaljobs','vacancies'])->toArray();
        return $this->onSuccess($jobs);
    
    }
    public function homePageBanner(Request $request) {
        if($request->lang === '1'){
            $banner = HomeBanner::all('id', 'avatar', 'en_text');
            return $this->onSuccess($banner);
        }
        if($request->lang === '2'
        ){
            $banner = HomeBanner::all('id', 'avatar', 'ar_text');
            return $this->onSuccess($banner);
        }else{
            return $this->onSuccess("Invilid, Please send 1 for English or 2 for Arabic titles");
        }
    }
}
