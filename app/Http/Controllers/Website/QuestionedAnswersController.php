<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Website\QuestionedAnswers;
use App\Models\User;
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
        $faq = QuestionedAnswers::all();

        return $this->onSuccess($faq);
    }
}
