<?php

namespace App\Http\Controllers;
use App\Models\Curriculums;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function returnCurriculms(){
        $curr  = Curriculums::all();
        return $curr;
    }
}
