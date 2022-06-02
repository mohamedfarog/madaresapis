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

    public function aboutData(Request $request){
        //$lang= $request->header('accept_language');
        $about = new About();
        $data['total_jobs']= $about->totalJobs();
        $data['total_teachers']= $about->totalTeachers();
        $data['total_schools']= $about->totalSchools();
        $data['total_accepted ']= $about->totalAccepted();
        if($request->lang === '1'){
            $data['comments'] = About::all(['id','en_title','en_name', 'en_body', 'en_name'])->append('');
            return $this->onSuccess($data);
        }
        if($request->lang === '2'){
            $data['data'] = About::all(['id','ar_title','ar_name', 'ar_body','ar_name']);
            return $this->onSuccess($data);
        }
        else{
     
            return $this->onSuccess("Invalid Input");
        }
      
    }
}
