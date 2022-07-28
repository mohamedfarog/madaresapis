<?php
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Academies\Academy;
use App\Models\Academies\AcademyFile;
use Illuminate\Support\Facades\Auth;
use App\Models\YearOfTeaching;
use App\Models\AcademySize;
use Illuminate\Http\Request;
use App\Traits\fileUpload;
use File;

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

use fileUpload;

public function deleteAcademyFile(Request $request){
     
        $userId = Auth::id();
        $academyFile = AcademyFile::where('academy_id',  $userId)->where('id', $request->file_id)->first();
        if(!$academyFile){
            return $this->onError('Teacher File does not exist');
        }
        $academyFile->delete();
        return $this->onSuccess('Academy ile is deleted');
    } 
    
    public function getAcademyFile(){
        $teacherId =  auth::id();
        return $this->onSuccess(AcademyFile::where('academy_id', $teacherId)->get());
    }
    public function updateAcademyFile(Request $request){
        $userId = Auth::id();
        $academyFile = AcademyFile::where('academy_id',  $userId)->where('id', $request->file_id)->first();
        if(!$academyFile){
            return $this->onError('Academy File does not exist');
        }
        if($file = $request->file_url){

               $academy_file = time() . '_' . $request->file_url->getClientOriginalName();
               $academy_file = $this->uploadFile($file, 'academyFiles');
               //$academy_file = $request->file_url->store('academyFiles'); 
               $academyFile->file_url = $academy_file;
        }
        $academyFile->save();
        return $this->onSuccess($academyFile);
}

public function getAcademyHeadercount(){
        $academy = new Academy();
        $data['profile_views'] = $academy->profileViews();
        $data['unread_messages'] = $academy->unReadMessages();
        $data['received_applications'] = $academy->applicationsReceived();
        $data['answered_applications'] = $academy->applicationsAnswered();
        $data['applicants_interviewed'] = $academy->interviewedApplicants();
        $data['applicants_hired'] = $academy->HiredApplicants(); 
        return $this->onSuccess($data);
}
public function AllRecivedApplications(){
        $academy = new Academy();
        $data['last_eight_months'] = $academy->receivedApplicationsForLast8Month();
        $data['last_month'] = $academy->receivedApplicationsForLastMonth();
        $data['last_week'] = $academy->receivedApplicationsForLastWeek(); 
        return $this->onSuccess($data);
}
public function AllRejectedApplications(){
        $academy = new Academy();
        $data['last_eight_months'] = $academy->rejectedApplicationsForLast8Month();
        $data['last_month'] = $academy->rejectedApplicationsForLastMonth();
        $data['last_week'] = $academy->rejectedApplicationsForLastWeek(); 
        return $this->onSuccess($data);
}

public function AllInterviwedApplications()
{
        $academy = new Academy();
        $data['last_eight_months'] = $academy->interviwedApplicationsForLast8Month();
        $data['last_month'] = $academy->interviwedApplicationsForLastMonth();
        $data['last_week'] = $academy->interviwedApplicationsForLastWeek(); 
        return $this->onSuccess($data);
}
public function academyYearsOfTeaching(Request $request){
        if($request->lang == 1){
                return $this->onSuccess(YearOfTeaching::all('id', 'title_ar'));  

        }
        else{
                return $this->onSuccess(YearOfTeaching::all('id', 'title_en'));
        }
}

public function academySize(Request $request){
        if($request->lang == 1){
                return $this->onSuccess(YearOfTeaching::all('id', 'title_ar'));
        }
        else{
                return $this->onSuccess(YearOfTeaching::all('id', 'title_en'));
        }
}
public function createBlogs(Request $request){
        
}
}

