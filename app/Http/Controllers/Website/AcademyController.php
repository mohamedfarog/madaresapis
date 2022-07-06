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
   public function getAcademyHeadercount(){
        $academy = new Academy();
        $data['profile_views'] = $academy->profileViews();
        $data['unread_messages'] = $academy->unReadMessages();
        $data['aeceived_applications'] = $academy->applicationsReceived();
        $data['answered_applications'] = $academy->applicationsAnswered();
        $data['applicants_interviewed'] = $academy->interviewedApplicants();
        $data['applicants_hired'] = $academy->HiredApplicants();
       
        return $this->onSuccess($data);
        

        
   }
}
