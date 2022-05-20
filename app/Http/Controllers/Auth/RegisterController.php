<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $user = $this->create($request->all());

        return $this->login($request);
    }



    protected function create(array $data)
    {
        
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
    
         ]);
         $adminRole = Role::where('name','admin')->first();
         $user->roles()->attach($adminRole);
         return $user;


    }
    
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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
