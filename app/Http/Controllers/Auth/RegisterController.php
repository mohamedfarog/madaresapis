<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Locations;
use App\Models\Jobs\JobLevel;
use App\Models\Academies\AcademyFile;
use App\Models\Academies\AcademyLevels;
use App\Models\Academies\Academy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use File;
class RegisterController extends Controller
{
    public function UpdateUserType(Request $request){
        try{
            $userType = User::findOrFail($request->id);
            if(asset($request->type)){
                $userType->user_type = $request->type;
            }
            $userType->save();
            if($request->type === '255'){
                $upload = new File();
                $validator = Validator::make($request->all(), [
                    'attachments.*' => 'mimes:png,jpg,jpeg,svg,csv,txt,xlx,xls,xlsx,pdf,doc,docx,zip,rar,wav,mp3,mp4,mov,mkv,webm,avi,ogg,m4a,flac,wma,aac,sketch,psd']);
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()], 401);
                }
                //$fileName = time().'_'.$request->AcademyFiles[]->getClientOriginalName();
                //$filePath = $request->file('file_url')->storeAs('uploads', $fileName, 'public');
                $academy = new Academy();
                if(asset($request->user_id)){
                    $academy->user_id = $request->user_id;
                }
                if(asset($request->ar_name)){
                    $academy->ar_name = $request->ar_name;
                }
                if(asset($request->en_name)){
                    $academy->en_name = $request->en_name;
                }
                  if(asset($request->contact_number)){
                    $academy->contact_number = $request->contact_number;
                }
                if(asset($request->en_bio)){
                    $academy->en_bio = $request->en_bio;
                }
                if(asset($request->ar_bio)){
                    $academy->ar_bio = $request->ar_bio;
                }
                if(asset($request->banner)){
                    $academy->banner = $request->banner;
                }
                if(asset($request->avatar)){
                    $academy->avatar = $request->avatar;
                }
                if(asset($request->website)){
                    $academy->website = $request->website;
                }
                $academy->save();
                $location = new Locations();
                if(asset($request->id)){
                    $location->academy_id = $request->id;
                }
                if(asset($request->country_id)){
                    $location->country_id = $request->country_id;
                }
                if(asset($request->ar_city)){
                    $location->ar_city_name = $request->ar_city;
                }
                if(asset($request->en_city)){
                    $location->en_city_name = $request->en_city;
                }
                if(asset($request->en_country)){
                    $location->en_country = $request->en_country;
                }
                if(asset($request->ar_country)){
                    $location->ar_country = $request->ar_country;
                }
                if(asset($request->en_street)){
                    $location->en_street = $request->en_street;
                }
                if(asset($request->ar_street)){
                    $location->ar_street = $request->ar_street;
                }
       
                if(asset($request->location_code)){
                    $location->location_code = $request->location_code;
                }
                if(asset($request->building_no)){
                    $location->building_no = $request->building_no;
                }
                $location->save();
  
                foreach ($request->academy_levels['job_level_id'] as $level){
                    $aca_level = new AcademyLevels();
                    $aca_level->academy_id = $request->id;
                    $aca_level->level_id = $level;
                    $aca_level->save();  
                } 
                 if(isset($request->AcademyFiles)) {
                 
                   // $academyFile = $request->$image->file('image')->storeAs('uploads', $image, 'public');
                    foreach ($request->AcademyFiles as $image) {
                        $fileNmae = time().'_'.$image->getClientOriginalName();
                        $fileNmae = $image->store('AcademyFiles');
                        $academyFile = new AcademyFile();
                        $academyFile['file_url'] = $fileNmae;
                        $academyFile->academy_id = $request->id;
                        $academyFile->save();
    
                    }
                }
                // $academy_file = new AcademyFile();
                // if(asset($request->file_url)){
                //     $academy_file->file_url = $filePath;
                    
                // }
                // if(asset($request->id)){
                //     $academy_file->academy_id = $request->id;
                // }
                // $academy_file->save();
                return $this->onSuccess("academy Data insterted");
            }
            if($request->type === '256'){
                return $this->onSuccess("Teaher form to academy page");
            }
            else{
                return $this->onError('User Type is undefined');
            }
        }
       catch(ModelNotFoundException $e){
        return $this->onError('User ID NOT FOUND');
    }
}
        public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'Successfully Registered!'

        ]);
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
 
