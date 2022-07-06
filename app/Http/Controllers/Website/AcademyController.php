<?php
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Academies\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response
     */
    public function academyData(){

            $academy = Academy::all('id', 'name', 'avatar')->append(['Totaljobs'])->toArray();
            return $this->onSuccess($academy);
        }
    public function profileViews(){
        return $this->onSuccess(0);
}
public function unReadMessages(){
        return $this->onSuccess(0);
}
public function applicationsReceived(){
        return $this->onSuccess(0);
}
public function applicationsAnswered(){
        return $this->onSuccess(0);
}
public function interviewedApplicants(){
        return $this->onSuccess(0);
}
public function HiredApplicants(){
        return $this->onSuccess(0);
}
}
