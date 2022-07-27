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
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Storage;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class RegisterController extends Controller
{
    public function reSendVerificationSendEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $user = User::where('email',  $request->email)->first();
        if ($user->email_verified == 1) {
            return $this->onError('This User is already verified');
        } else {
            $vCode = Str::random(30);
            $details = [
                'title' => 'Verified Email',
                'body' => 'Email Verification Body'
            ];
            Mail::to($request->email)->send(new AppMail($vCode, $details));
            $user->verify_email_token = $vCode;
            $user->verify_email_token_created_at = Carbon::now()->toDateTimeString();
            $user->save();
            return $this->onSuccess();
        }
    }
    function sendVerificationEmail($email, $userId)
    {
        $vCode = Str::random(30);
        $details = [
            'title' => 'Verified Email',
            'body' => 'Email Verification Body'
        ];
        Mail::to($email)->send(new AppMail($vCode, $details));
        $user = User::find($userId);
        $user->verify_email_token = $vCode;
        $user->verify_email_token_created_at = Carbon::now()->toDateTimeString();
        $user->save();
        return $user;
    }
    public function updateTeacherAvatar(Request $request)
    {

        $teacher = Teacher::where('user_id', auth::id())->first();
          if ($file = $request->avatar) {
                $icon = $this->uploadFile($file, 'avatars');
                $teacher->avatar = $icon;
            }
            $teacher->save();
            return $this->onSuccess($teacher);
        }

    public function updateAcademyAvatar(Request $request)
    {
        $academy = Academy::where('user_id', auth::id())->first();
          if ($file = $request->avatar) {
                $icon = $this->uploadFile($file, 'avatars');
                $academy->avatar = $icon;
            }
            $academy->save();
            return $this->onSuccess($academy);
        }

    public function testVerifyEmail(Request $request)
    {
        $this->sendVerificationEmail($request->email, 1);
        return 'success';
    }
    use fileUpload;
    public function UpdateUserType(Request $request)
    {
        if ($request->type != 255 && $request->type != 256) {
            return $this->onError('Please Enter a valid User type');
        }

        $userId = Auth::id();
        $userType = User::findOrFail($userId);

        if ($userType->user_type == '255' || $userType->user_type == '256') {
            if ($userType->user_type != $request->type)
                return $this->onError("Sorry This User already has a type");
        }
        if ($userType->email_verified == 0) {
            return $this->onError('This User is not verified yet');
        }
        $userType->user_type = $request->type;
        $userType->save();
        $token = JWTAuth::fromUser($userType);

        if ($userType->user_type  == '255') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'bio' => 'required',
                'country' => 'required',
                'city' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->onError($validator->errors()->all());
            }
            $location = new Locations();
            if ($request->type == '256') {
                $location->teacher_id = $userId;
            } else {
                $location->academy_id = $userId;
            }

            if (isset($request->city)) {
                $location->city = $request->city;
            }
            if (isset($request->country)) {
                $location->country = $request->country;
            }
            if (isset($request->street)) {
                $location->street = $request->street;
            }
            $location->save();

            $academy = new Academy();
            $academy->user_id = $userId;
            if (isset($request->name)) {
                $academy->name = $request->name;
            }
            if (isset($request->contact_number)) {
                $academy->contact_number = $request->contact_number;
            }
            if (isset($request->bio)) {
                $academy->bio = $request->bio;
            }
            if ($file = $request->avatar) {
                $icon = $this->uploadFile($file, 'avatars');
                $academy->avatar = $icon;
            }
            if (isset($request->years_of_teaching_id)) {
                $academy->years_of_teaching_id = $request->years_of_teaching_id;
            }
            if (isset($request->academy_size_id)) {
                $academy->academy_size_id = $request->academy_size_id;
            }
            $academy->save();
            if (is_array($request->academy_levels) || is_object($request->academy_levels)) {
                $academy_levels = [];
                foreach ($request->academy_levels as $level) {

                    array_push($academy_levels, [
                        "academy_id" => $userId,
                        "level_id" => $level
                    ]);
                }
                AcademyLevels::insert($academy_levels);
            }
            if (is_array($request->academy_files) || is_object($request->academy_files)) {
                $AcademyFiles = [];
                foreach ($request->academy_files as $image) {
                    $academyImages = $this->uploadFile($image, 'academyFiles');
                    array_push($AcademyFiles, [
                        "file_url" =>  $academyImages,
                        "academy_id" =>  $userId

                    ]);
                    AcademyFile::insert($AcademyFiles);
                }
            }
            $academyData = Academy::with(['AcademyLevels', 'academyLocations', 'academyFiles'])->where('user_id', $userId)->first();
            return response()->json([
                'status' => true,
                'data' => $academyData,
                'token' => $token,
                'user' => $userType,
                'message' => 'Successfully Registered!'
            ]);
        }
        if ($request->type == '256') {
            $validator = Validator::make($request->all(), [
                'country' => 'required',
                'city' => 'required',
                'gender_id' => '',
                'curriculum_vitae' => 'required',
                'bio' => 'required',
                'education' => 'required|array',
                'education.*.edu_title' => 'required|string',
                'experience' => 'required|array',
                'experience.*.start_day' => 'required|date|before:tomorrow',
                'experience.*.end_day' => 'required|date|after_or_equal:experience.*.start_day',
                'experience.*.exp_title' => 'required|string',
                'experience.*.place_of_assurance' => 'required|string',
            ], [], [
                "education.*.edu_title" => "certification name",
                "experience.*.start_day" => "work started date",
                "experience.*.end_day" => "work finished date",
                "experience.*.exp_title" => "experience position",
                "experience.*.place_of_assurance" => "academy name",
            ]);
            if ($validator->fails()) {
                return $this->onError($validator->errors()->all());
            }
            $teacher = new Teacher();
            $teacher->user_id = $userId;

            if (isset($request->gender_id)) {

                $teacher->gender_id = $request->gender_id;
            } else {
                $teacher->gender_id = 1;
            }
            if (isset($request->contact_number)) {
                $teacher->contact_number = $request->contact_number;
            }
            if (isset($request->date_of_birth)) {
                $teacher->date_of_birth = $request->date_of_birth;
            }
            if (isset($request->first_name)) {
                $teacher->first_name = $request->first_name;
            }

            if (isset($request->last_name)) {
                $teacher->last_name = $request->last_name;
            }
            if (isset($request->bio)) {
                $teacher->bio = $request->bio;
            }
            if (isset($request->willing_to_travel)) {
                $teacher->willing_to_travel = $request->willing_to_travel;
            }
            if (isset($request->availability_id)) {
                $teacher->availability_id = $request->availability_id;
            }
            if ($file = $request->avatar) {
                $icon = $this->uploadFile($file, 'avatars');
                $teacher->avatar = $icon;
            }
            $teacher->save();
        }
        $location = new Locations();
        if ($request->type == '256') {
            $location->teacher_id = $userId;
        } else {
            $location->academy_id = $userId;
        }
        if (isset($request->city)) {
            $location->city = $request->city;
        }
        if (isset($request->country)) {
            $location->country = $request->country;
        }
        if (isset($request->street)) {
            $location->street = $request->street;
        }
        $location->save();
        $skills = [];
        if (is_array($request->skills) || is_object($request->skills)) {
            foreach ($request->skills as $skill) {
                array_push($skills, [
                    'teacher_id' => $userId,
                    'skill_id' => $skill
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
        if (isset($request->skill_name)) {
            $teachDoc->extra_skills = $request->extra_skills;
        }
        $teachDoc->save();

        if (is_array($request->experience) || is_object($request->experience)) {

            foreach ($request->experience as $texp) {
                $exp = new TeacherExperience();
                $exp->teacher_id = $userId;
                $exp->title = $texp['exp_title'];
                $exp->start_day = $texp['start_day'];
                $exp->place_of_assurance = $texp['place_of_assurance'];
                $exp->end_day = $texp['end_day'];
                $exp->save();
            }
        }
        if (is_array($request->education) || is_object($request->education)) {
            foreach ($request->education as $tedu) {
                $edu = new TeacherEducation();
                $edu->teacher_id = $userId;
                $edu->title = $tedu['edu_title'];
                $edu->start_date = $tedu['start_date'];
                $edu->end_date = $tedu['end_date'];
                $edu->save();
            }
        }
        //TODO:: check
        $available = new Availability();
        $available->teacher_id = $userId;
        $available->save();

        $TeacherFiles = [];
        if (is_array($request->teacher_files) || is_object($request->teacher_files)) {
            foreach ($request->teacher_files as $tFile) {
                $teacherfiles = $this->uploadFile($tFile, 'teacherFiles');
                array_push($TeacherFiles, [
                    "file_url" =>  $tFile,
                    "teacher_id" =>  $userId
                ]);


            }
            TeacherFiles::insert($TeacherFiles);
        }
        $teacherData = Teacher::with(['resumes', 'teacherLocations', 'teacherSkills', 'teacherAvailabity', 'experiences', 'teacherFiles', 'education'])->where('user_id', $userId)->first();
        $userType->verify_email_token = NULL;
        $userType->verify_email_token_created_at = NULL;
        return response()->json([
            'status' => true,
            'data' => $teacherData,
            'token' => $token,
            "user" => $userType,
            'teacherFiles' => $TeacherFiles,
            'message' => 'Successfully Registered!'
        ]);
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
        $user =  User::where('email', $request->email)->get(['id', 'email', 'is_active', 'email_verified'])->first();
        return response()->json([
            'status' => true,
            'user' => $user,
            'token' => JWTAuth::fromUser($user),
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
    public function search_teachers(Request $request)
    {
        // With Teacher, Country / City / Experience / Gender /Current Position
        $user = User::whereNotNull('email_verified_at')->where('user_type', '256')->with(['teacher' => function ($q) {
            return $q->with(['teacherLocations', 'teacherSkills', 'resumes', 'experiences', 'teacherFiles', 'education', 'teacherAvailabity']);
        }])->whereHas('teacher')->paginate();
        return $this->onSuccess($user);
    }
    public function teacher_info(Request $request, $id)
    {
        // With Teacher, Country / City / Experience / Gender /Current Position
        $user = User::whereNotNull('email_verified_at')->where('user_type', '256')->where('id', $id)->with(['teacher' => function ($q) {
            return $q->with(['teacherLocations', 'teacherSkills', 'resumes', 'experiences', 'teacherFiles', 'education', 'teacherAvailabity']);
        }])->first();
        return $this->onSuccess($user);
    }
}
