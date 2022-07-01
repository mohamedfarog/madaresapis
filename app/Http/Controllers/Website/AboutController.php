<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\Website\About;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Expr\FuncCall;
class AboutController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */

    public function aboutData(){
        $about = new About();
        $data['total_jobs']= $about->totalJobs();
        $data['total_teachers']= $about->totalTeachers();
        $data['total_schools']= $about->totalSchools();
        $data['total_accepted ']= $about->totalAccepted();

            $data['comments'] = About::all(['id','title','name', 'body', 'name'])->append('');
            return $this->onSuccess($data);
       
      
    }
}
