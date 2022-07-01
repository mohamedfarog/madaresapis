<?php 

namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller { 

  public function getPassword($token) { 

     return view('customauth.passwords.reset', ['token' => $token]);
  }

  public function updatePassword(Request $request)
  {

  $request->validate([
    //  'token' => 'required|email|exists:users',
      'password' => 'required|string|min:6|confirmed',
      'password_confirmation' => 'required',

  ]);
  $updatePassword = DB::table('password_resets')
                      ->where(['token' => $request->token])
                      ->first();
  if(!$updatePassword)
  return $this->onError('Invalid token');

     // return back()->withInput()->with('error', 'Invalid token!');
 

     //get user email from password_resets
     $getUserEmail = DB::table('password_resets')
     ->where(['token' => $request->token])
     ->first();
    $user = User::where('email', $getUserEmail->email)
                ->update(['password' => Hash::make($request->password)]);
    DB::table('password_resets')->where(['token'=> $request->token])->delete();
    return $this->onSuccess('Password has been changed');

    // return redirect('/login')->with('message', 'Your password has been changed!');
  }
}