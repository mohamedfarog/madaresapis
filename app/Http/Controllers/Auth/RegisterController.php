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
use App\Models\Teachers\TeacherEducation;
use App\Models\Teachers\TeacherResume;
use App\Http\Requests\RegisterRequest;
use App\Mail\AppMail;
use App\Models\Teachers\TeacherFiles;
use Carbon\Carbon;
use App\Traits\fileUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use File;
use Illuminate\Support\Facades\Storage;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class RegisterController extends Controller
{
    public function reSendVerificationSendEmail(Request $request)
    {
        $user = User::where('email',  $request->email)->first();
        if ($user->email_verified == 1){
            return $this->onError('This User is already verified');
        }
        else{
            $vCode = Str::random(30);
            Mail::to($request->email)->send(new AppMail($vCode));
            $user->verify_email_token = $vCode;
            $user->verify_email_token_created_at = Carbon::now()->toDateTimeString();
            $user->save();
            return $this->onSuccess();
        }
    }
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
    use fileUpload;
    public function UpdateUserType(Request $request)
    {
        try {
            
            $userType = User::findOrFail($request->id);
            if($userType->email_verified == 0 && $request->type == 255){
                return $this->onError('This User is not verified yet');
            }
            elseif($request->type != 255 && $request->type != 256 ){
                return $this->onError('Please Enter a vaild User type');
             }
            elseif ($userType->user_type == '255' || $userType->user_type == '256') {
                return $this->onError("Sorry This User already has a type");
            } 
            else {
                $userType->user_type = $request->type;
                $userType->save();
                if ($userType->user_type  == '255') {
                    $userId = $request->id;
                    $academy = new Academy();
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'contact_number' => 'required',
                        'bio' => 'required',
                        'avatar' => 'required',
                        'years_of_teaching' => 'required',
                        'size' => 'required',
                        'avatar' => 'required'
                    ]);
                    if ($validator->fails()) {
                        return $this->onError($validator->errors()->all());
                    }
                    $academy->user_id = $userId;
                    if (asset($request->name)) {
                        $academy->name = $request->name;
                    }
                    if (asset($request->contact_number)) {
                        $academy->contact_number = $request->contact_number;
                    }
                    if (asset($request->bio)) {
                        $academy->bio = $request->bio;
                    }
                    if ($file = $request->avatar) {
                        $icon = $this->uploadFile($file, 'avatars');
                        $academy->avatar = $icon;
                    }
                    if (asset($request->years_of_teaching)) {
                        $academy->years_of_teaching = $request->years_of_teaching;
                    }
                    if (asset($request->size)) {
                        $academy->size = $request->years_of_teaching;
                    }
                    $academy->save();
                    $location = new Locations();
                    $academy->user_id = $userId;

                    if (asset($request->city)) {
                        $location->city = $request->city;
                    }
                    if (asset($request->country)) {
                        $location->country = $request->country;
                    }
                    if (asset($request->street)) {
                        $location->street = $request->street;
                    }
                    $location->save();

                    $academy_levels = [];
                    if (is_array($request->academy_levels) || is_object($request->academy_levels)) {
                        foreach ($request->academy_levels as $level) {
                            array_push($academy_levels, [
                                "academy_id" => $userId,
                                "level_id" => $level
                            ]);
                        }
                        AcademyLevels::insert($academy_levels);
                    }
                    
                    $AcademyFiles = [];
                    if (is_array($request->AcademyFiles) || is_object($request->AcademyFiles)) {
                        foreach ($request->AcademyFiles as $image) {
                            $academyImages = $this->uploadFile($image, 'academyFiles');

                            array_push($AcademyFiles, [
                                "file_url" =>  $academyImages,
                                "academy_id" =>  $userId

                            ]);
                        }
                        AcademyFile::insert($AcademyFiles);
                    }

                    $academyData = Academy::with(['AcademyLevels', 'academyLocations', 'academyFiles'])->where('user_id', $userId)->get();
                    return $this->onSuccess($academyData);
                }
                if ($request->type == '256') {
                    $userType->save();
                    $UVEmail = User::where('id',$request->id)->first();
                    $UVEmail->email_verified = 1;
                    $UVEmail->save();
                    $userId = $request->id;
                    $teacher = new Teacher();
                    $validator = Validator::make($request->all(), [
                        'gender_id' => 'sometimes|required',
                        'contact_number' => 'required',
                        'contact_number' => 'required',
                        'date_of_birth' => 'required',
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'bio' => 'required',
                        'willing_to_travel' => 'required',
                        'availability_id' => 'required',
                        'avatar' => 'required'
                    ]);

                    if ($validator->fails()) {
                        return $this->onError($validator->errors()->all());
                    }
                    $teacher->user_id = $userId;

                    if (asset($request->gender_id)) {
                        $teacher->gender_id = $request->gender_id;
                    }

                    if (asset($request->contact_number)) {
                        $teacher->contact_number = $request->contact_number;
                    }
                    if (asset($request->date_of_birth)) {
                        $teacher->date_of_birth = $request->date_of_birth;
                    }
                    if (asset($request->first_ame)) {
                        $teacher->first_name = $request->first_name;
                    }

                    if (asset($request->last_name)) {
                        $teacher->last_name = $request->last_name;
                    }
                    if (asset($request->bio)) {
                        $teacher->bio = $request->bio;
                    }
                    if (asset($request->willing_to_travel)) {
                        $teacher->willing_to_travel = $request->willing_to_travel;
                    }
                    if (asset($request->availability_id)) {
                        $teacher->availability_id = $request->availability_id;
                    }
                    if ($file = $request->avatar) {
                        $icon = $this->uploadFile($file, 'avatars');
                        $teacher->avatar = $icon;
                    }
                    $teacher->save();
                }
                $userId = $request->id;
                $location = new Locations();
                $location->teacher_id = $userId;

                if (asset($request->ar_city)) {
                    $location->ar_city_name = $request->ar_city;
                }
                if (asset($request->city)) {
                    $location->city = $request->city;
                }
                if (asset($request->country)) {
                    $location->country = $request->country;
                }

                if (asset($request->street)) {
                    $location->street = $request->street;
                } else {

                    return $this->onError('User Type is undefined');
                }

      
                $skills = [];

                if (is_array($request->skills) || is_object($request->skills)) {

                    $userId = $request->id;
                    foreach ($request->skills as $skill) {
                        array_push($skills, [
                            'teacher_id' => $userId,     
                            'kill_id' => $skill

                        ]);
                    }
                    Skills::insert($skills);
                }
                $teachDoc =  new TeacherResume();
                $teachDoc->teacher_id = $userId;

                if (isset($request->curriculum_vitae)) {
                    $fileNmae = time() . '_' . $request->curriculum_vitae->getClientOriginalName();
                    $fileNmae = $request->curriculum_vitae->store('public/uploads/resumes');
                    $teachDoc->curriculum_vitae = $fileNmae;
                }

                if (isset($request->cover_litter)) {
                    $fileNmae = time() . '_' . $request->cover_litter->getClientOriginalName();
                    $fileNmae = $request->cover_litter->store('public/uploads/cover_letters');
                    $teachDoc->cover_litter = $fileNmae;
                }
                if (isset($request->skill_name)) {
                    $teachDoc->extra_skills = $request->extra_skills;
                }
                $teachDoc->save();
                if (is_array($request->experience) || is_object($request->experience)) {

                    $userId = $request->id;
                    foreach ($request->experience as $texp) {
                        $exp = new TeacherExperience();
                        $exp->teacher_id = $userId;
                        $exp->titel = $texp['exp_title'];
                        $exp->start_day = $texp['start_day'];
                        $exp->place_of_assuarance = $texp['place_of_assuarance'];
                        $exp->end_day = $texp['end_day'];
                    }
                    $exp->save();
                }

                $teachDoc->save();
                if (is_array($request->education) || is_object($request->education)) {

                    $userId = $request->id;
                    foreach ($request->education as $tedu) {
                        $edu = new TeacherEducation();
                        $edu->teacher_id = $userId;
                        $edu->title = $tedu['edu_title'];
                        $edu->start_date = $tedu['start_date'];
                        $edu->end_date = $tedu['end_date'];
                    }
                    $edu->save();
                }
                $userId = $request->id;
                $available = new Availability();
                $available->teacher_id = $userId;
                if (asset($request->time_available)) {
                    $available->time_available = $request->time_available;
                }
                $available->save();
                $userId = $request->id;
                $TeacherFiles = [];
                if (is_array($request->TeacherFiles) || is_object($request->TeacherFiles)) {
                    foreach ($request->TeacherFiles as $tFile) {
                        $teacherfiles = $this->uploadFile($tFile, 'teacherFiles');

                        array_push($TeacherFiles, [
                            "file_url" =>  $teacherfiles,
                            "teacher_id" =>  $userId

                        ]);
                    }
                    TeacherFiles::insert($TeacherFiles);
                }
                $teacherData = Teacher::with(['resumes', 'teacherLocations', 'teacherSkills', 'teacherAvailabity', 'experiences', 'teacherFiles', 'education'])->where('user_id', $userId)->get();
                return $this->onSuccess($teacherData);
            }
        } catch (ModelNotFoundException $e) {
            return $this->onError('User ID NOT FOUND');
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);


        if ($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $this->sendVerificationEmail($request->email, $user->id);
        $user1 =  User::where('email', $request->email)->get(['id', 'email', 'is_active', 'email_verified'])->first();
        return response()->json([
            'status' => true,
            'user' => $user1,
            'message' => 'Successfully Registered!'
        ]);
    }
    public function ueserRegistered()
    {
        if (Auth::check()) {
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
            return view('emails.codeExpired');
        }
        $user->email_verified = 1;
        $user->verify_email_token = null;
        $user->verify_email_token_created_at = null;
        $user->save();
        return view('emails.emailVerfied');
    }

    public function returnEmailVerifyed(Request $request)
    {
        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail['email_verified'] == 1) {
            return $this->onSuccess('Email is verifed');
        } else { {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is not verifed',
                ], 200);
            }
        }
    }
    public function setTypeToNull(Request $request)
    {
        $setType = User::where('email', $request->email)->first();
        $setType->user_type = null;
        $setType->save();
    }
}



