<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Jobs\Job;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobController extends Controller
{
    //
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate()->id;
        return $user;
        $job = new Job();
    }
}
