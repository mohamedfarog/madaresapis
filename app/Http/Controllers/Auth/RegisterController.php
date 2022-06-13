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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    public function UpdateUserType(Request $request){
       
        $checkUserTypeId = UserType::findOrFail('user_id', $request->user_id);
        
        if($checkUserTypeId){
            return "found";
        }
        else{
            return "NO";
        }
  
    }
        public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return $this->onError("The email has already been taken");
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
 
