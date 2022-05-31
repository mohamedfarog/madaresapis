<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;

use App\Models\Teachers\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TeachersController extends Controller
{

       /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    
    
    public function teacherData(Request $request)
    {
        if($request->lang === '1'){
            $teacher = Teacher::all('id', 'first_name', 'avatar', 'academic_major')->append(['Experience'])->toArray();
            return $this->onSuccess($teacher);
        }
        if($request->lang === '2'){
            $teacher = Teacher::all('id', 'first_name', 'avatar', 'academic_major')->append(['Experience'])->toArray();
            return $this->onSuccess($teacher);
        }
        else{
            return $this->onSuccess('Invild lang Input');
        }
    }
}
