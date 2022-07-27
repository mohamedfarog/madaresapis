<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Models\Teachers\TeacherFiles;
use Illuminate\Support\Facades\Auth;
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
    
    
    public function teacherData()
    {
        $teacher = Teacher::all('id', 'first_name', 'avatar', 'academic_major')->append(['Experience'])->toArray();
        return $this->onSuccess($teacher);
    }


    public function deleteTeacherFile(Request $request){
        $userId = Auth::id();
        $teacherFile = TeacherFiles::where('teacher_id',  $userId)->where('id', $request->file_id)->first();
        if(!$teacherFile){
            return $this->onError('Teacher File does not exist');
        }
        $teacherFile->delete();
        return $this->onSuccess('Teacher ile is deleted');
    } 
    
    public function getAllFilesForThisTeacher(){
        $teacherId =  auth::id();
        return $this->onSuccess(TeacherFiles::where('teacher_id', $teacherId)->get());
    }

    public function updateTeacherFile(Request $request){

        $userId = Auth::id();
        $teacherFile = TeacherFiles::where('teacher_id',  $userId)->where('id', $request->file_id)->first();
        if(!$teacherFile){
            return $this->onError('Teacher File does not exist');
        }
        if(isset($request->file_name)){
            $teacherFile->file_name = $request->file_name;
            
        }
        if(isset($request->file_url)){
            $teacherFile->file_url = $request->file_url;
        }
        $teacherFile->save();
        return $this->onSuccess($teacherFile);
      
    }


    
}
