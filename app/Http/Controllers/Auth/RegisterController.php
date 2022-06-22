<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Locations;
use App\Models\Skills;
use App\Models\Availability;
use App\Models\Jobs\JobLevel;
use App\Models\Academies\AcademyFile;
use App\Models\Academies\AcademyLevels;
use App\Models\Academies\Academy;
use App\Models\Teachers\Teacher;
use App\Models\Teachers\TeacherExperience;
use App\Models\Teachers\TeacherResume;
use App\Http\Requests\RegisterRequest;
use App\Mail\AppMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use File;


class RegisterController extends Controller
{
    function sendVerificationEmail($email, $userId)
    {
        $vCode = Str::random(30);
        Mail::to($email)->send(new AppMail($vCode));
        $user = User::find($userId);
        $user->verify_email_token = $vCode;
        $user->verify_email_token_created_at = Carbon::now()->toDateTimeString();
        $user->save();
        return $user;
    }
    public function testVerifyEmail(Request $request)
    {
        $this->sendVerificationEmail($request->email, 1);
        return 'success';
    }
    //
    public function UpdateUserType(Request $request)
    {

      
        try {
            $userType = User::findOrFail($request->id);
            if ($userType->user_type === '255' || $userType->user_type === '256' ) {
                return $this->onError("Sorry This User already has a type");
            }
            else{
        
                $userType->user_type = $request->type;
                $userType->save();
                if ($userType->user_type  === '255') {
               
                    $userId = $request->id;
                     $academy = new Academy();
              
                        $academy->user_id = $userId;
                    
                    if (asset($request->ar_name)) {
                        $academy->ar_name = $request->ar_name;
                    }
                    if (asset($request->en_name)) {
                        $academy->en_name = $request->en_name;
                    }
                    if (asset($request->contact_number)) {
                        $academy->contact_number = $request->contact_number;
                    }
                    if (asset($request->en_bio)) {
                        $academy->en_bio = $request->en_bio;
                    }
                    if (asset($request->ar_bio)) {
                        $academy->ar_bio = $request->ar_bio;
                    }
                
                    if (asset($request->avatar)) {
                        $academy->avatar = $request->avatar;
                    }
                    if (asset($request->years_of_teaching)) {
                        $academy->years_of_teaching = $request->years_of_teaching;
                    }
                    if (asset($request->size)) {
                        $academy->size = $request->years_of_teaching;
                    }
                    $academy->save();
                    $location = new Locations();
                  
                        $location->teacher_id = $userId;
                    
                    if (asset($request->ar_city)) {
                        $location->ar_city_name = $request->ar_city;
                    }
                    if (asset($request->en_city)) {
                        $location->en_city_name = $request->en_city;
                    }
                    if (asset($request->en_country)) {
                        $location->en_country = $request->en_country;
                    }
                    if (asset($request->ar_country)) {
                        $location->ar_country = $request->ar_country;
                    }
                    if (asset($request->en_street)) {
                        $location->en_street = $request->en_street;
                    }
                    if (asset($request->ar_street)) {
                        $location->ar_street = $request->ar_street;
                    }
             
    
             
                    $location->save();
                    
                    if(asset($request->academy_levels )){
                        return "Hello";
                    }
                    foreach ($request->academy_levels as $level) {
                      
                        $aca_level = new AcademyLevels();
                        $aca_level->academy_id = $userId;
                        $aca_level->level_id = $level;
                        $aca_level->save();
                    }

                    //}
    
                    if (isset($request->AcademyFiles)) {
    
                        // $academyFile = $request->$image->file('image')->storeAs('uploads', $image, 'public');
                        foreach ($request->AcademyFiles as $image) {
                            $fileNmae = time() . '_' . $image->getClientOriginalName();
                            $fileNmae = $image->store('AcademyFiles');
                            $academyFile = new AcademyFile();
                            $academyFile['file_url'] = $fileNmae;
                            $academyFile->academy_id = $userId;
                            $academyFile->save();
                        }
                    } 
                   $academyData = Academy::with(['AcademyLevels', 'academyLocations','academyFiles'])->where('user_id',$userId)->get();
                    return $this->onSuccess($academyData);
                }
                else{
                    return "Noooo";
                }
                if ($request->type === '256') {
                    $userId = $request->id;
            
                    $teacher = new Teacher();
              
                        $teacher->user_id = $userId;
                    
                    if(asset($request->gender_id)){
                        $teacher->gender_id = $request->gender_id;
                    }
                    // if(asset($request->job_level_id)){
                    //     $teacher->job_level_id = $request->job_level_id;
                    // }
                    if(asset($request->contact_number)){
                        $teacher->contact_number = $request->contact_number;
                    }
                    if(asset($request->date_of_birth)){
                        $teacher->date_of_birth = $request->date_of_birth;
                    }
                    if(asset($request->en_first_ame)){
                        $teacher->en_first_name = $request->en_first_name;
                    }
                    if(asset($request->en_last_name)){
                        $teacher->en_last_name = $request->en_last_name;
                    }
                    if(asset($request->en_last_name)){
                        $teacher->en_last_name = $request->en_last_name;
                    }
                 
                    if(asset($request->ar_first_ame)){
                        $teacher->ar_first_name = $request->ar_first_name;
                    }
                    if(asset($request->ar_last_name)){
                        $teacher->ar_last_name = $request->ar_last_name;
                    }
                    if(asset($request->ar_last_name)){
                        $teacher->ar_last_name = $request->ar_last_name;
                    }
                    if(asset($request->en_bio)){
                        $teacher->en_bio = $request->en_bio;
                    }
                    if(asset($request->ar_bio)){
                        $teacher->ar_bio = $request->ar_bio;
                    }
                    if(asset($request->willing_to_travel)){
                        $teacher->willing_to_travel = $request->willing_to_travel;
                    }
                    if(asset($request->availability_id)){
                        $teacher->availability_id = $request->availability_id;
                    }
                    if(asset($request->avatar)){
                        $fileNmae = time().'_'.$request->avatar->getClientOriginalName();
                        $fileNmae = $request->avatar->store('public/uploads/logos');
                        $teacher->avatar = $fileNmae;
                    }
                    $teacher->save();
                }
                    $userId = $request->id;
                    $location = new Locations();      
                    $location->teacher_id = $userId;
                    
                    if (asset($request->ar_city)) {
                        $location->ar_city_name = $request->ar_city;
                    }
                    if (asset($request->en_city)) {
                        $location->en_city_name = $request->en_city;
                    }
                    if (asset($request->en_country)) {
                        $location->en_country = $request->en_country;
                    }
                    if (asset($request->ar_country)) {
                        $location->ar_country = $request->ar_country;
                    }
                    if (asset($request->en_street)) {
                        $location->en_street = $request->en_street;
                    }
                    if (asset($request->ar_street)) {
                        $location->ar_street = $request->ar_street;
                    }
    
                    else {
    
                        return $this->onError('User Type is undefined');
                    }
              
    
                    $location->save();
                    $userId = $request->id;
                    $skill = new Skills();
                    $skill->teacher_id = $userId;
                    if(isset($request->skill_ar_name)){
                        $skill->skill_ar_name = $request->skill_ar_name;
                    }
                    if(isset($request->skill_en_name)){
                        $skill->skill_en_name = $request->skill_en_name;
                    }
         
                    $skill->save();
    
                    $teachDoc =  new TeacherResume();
                   
                        $teachDoc->teacher_id = $userId;
                    
                    if (isset($request->curriculum_vitae)) {
                        $fileNmae = time().'_'.$request->curriculum_vitae->getClientOriginalName();
                        $fileNmae = $request->curriculum_vitae->store('public/uploads/resumes');
                        $teachDoc->curriculum_vitae = $fileNmae;
                    }
               
                    if (isset($request->cover_litter)) {
                        $fileNmae = time().'_'.$request->cover_litter->getClientOriginalName();
                        $fileNmae = $request->cover_litter->store('public/uploads/cover_letters');
                        $teachDoc->cover_litter = $fileNmae;
                        
                    } 
                    if(isset($request->skill_en_name)){
                        $teachDoc->extra_skills = $request->extra_skills;
                    }
                    $teachDoc->save();
    
                 
                    $userId = $request->id;
                    $available = new Availability();
                    $available->teacher_id = $userId;
                    if(asset($request->time_available)){
                        $available->time_available = $request->time_available;
                    }
               
                    
                    $available->save();
                  
                    $teacherData = Teacher::with(['resumes', 'teacherLocations','teacherSkills', 'teacherAvailabity'])->where('user_id', $userId)->get();
                    return $this->onSuccess($teacherData);
                }
            } catch (ModelNotFoundException $e) {
                return $this->onError('User ID NOT FOUND');
            }
          

        }
        public function register(Request $request)
        { $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        // $userType =  UserType::create([
        //     'type' => 3,
        //     'user_id' =>  $user['id'],
        // ]);
        // $U = User::with(['usertype'])->where('id', $user->id)->first(); 
        return $this->onSuccess($user);
    }   

        public function ueserRegistered()
        {
            if(Auth::check()){
                return  $this->onSuccess("Welcome");
            }
            return 'Opps! You do not have access';
        }
        protected function respondWithToken($token)
        {
            return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth::factory()->getTTL() * 60
        ]);
    }
    public function verifyEmail($token)
    {
        $user = User::where('verify_email_token', $token)->first();
        if (!$user) {
            return "code expired";
        }
        $user->email_verified = 1;
        $user->verify_email_token = null;
        $user->verify_email_token_created_at = null;
        $user->save();
        return "<h2>Email has been verified successfully";
    }
}
 
