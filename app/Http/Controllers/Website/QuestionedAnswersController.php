<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Website\QuestionedAnswers;
use App\Models\User;
use Illuminate\Support\Facades\App;

class QuestionedAnswersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function __invoke(): JsonResponse
    {
        App::setLocale('ar');
        $faq = QuestionedAnswers::all();
        
        
        $locale = App::currentLocale();
       
        // return ($locale);

        return $this->onSuccess($faq);
    }

    
   
    public function getSubjectsTitle()
    {
        echo "Hellllloooo";
        return "Hellooo";
    }
}
