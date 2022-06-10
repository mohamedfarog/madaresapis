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
        $checkUserTypeId = UserType::where('user_id', $request->user_id)->firstOrFail();
        if($checkUserTypeId ){
            return $this->onError('User Type already exist');
        }
        else{
            $UserType = UserType::create($request->toArray());
            
            return $this->onSuccess($UserType);
            // $U = User::with(['usertype'])->where('id', $request->user_id)->first();     

        }


       
      
        $checkUserTypeId = UserType::where('user_id', $request->id)->first();
        if($request->type){
         if (isset($request->type)) {
             $checkUserTypeId->type = $request->type;
          }
          $checkUserTypeId->save();
            $U = User::with(['usertype'])->where('id', $request->id)->first();
            return $this->onSuccess($U);     
        }
        else{
            return $this->onError('User id does not exist!');
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255| unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
