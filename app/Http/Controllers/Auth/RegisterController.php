<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use App\Models\UserType;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    public function UpdateUserType(Request $request){
       
         $userType = UserType::where('user_id', $request->id)->first();
          if (isset($request->type)) {
           $userType->type = $request->type;
            
         }
         $userType->save();
       
         $U = User::with(['usertype'])->where('id', $request->id)->first(); 
         return $this->onSuccess($U);
        }
        public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $userType =  UserType::create([
            'type' => 3,
            'user_id' =>  $user['id'],
        ]);
        $U = User::with(['usertype'])->where('id', $user->id)->first(); 
        return $this->onSuccess($U);
    }   
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(100),
            //$token = Auth::createToken('Laravel Password Grant Client')->accessToken,
            //$response = ['token' => $token],
        ]);
        //return  $response = ['token' => $token];
         $adminRole = Role::where('name','admin')->first();
         $user->roles()->attach($adminRole);
         return $user;
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
 
