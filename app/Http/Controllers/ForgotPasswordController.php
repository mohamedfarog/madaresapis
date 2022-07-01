<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon; 



class ForgotPasswordController extends Controller
{

 public function postEmail(Request $request)
 {
    
   $request->validate([
       'email' => 'required|email|exists:users',
   ]);

     $token = Str::random(64);
    
     DB::table('password_resets')->insert(
         ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
     );

     Mail::send('customauth.verify', ['token' => $token], function($message) use($request){
         $message->to($request->email);
         $message->subject('Reset Password Notification');
     });

     return $this->onSuccess();
 }

 public function reSendEmail(Request $request)
 {
    $request->validate([
        'email' => 'required|email|exists:users',
    ]);

    $getUser = DB::table('password_resets')->where('email', $request->email)->latest()->first();

    $token = $getUser->token;

    Mail::send('customauth.verify', ['token' => $token], function($message) use($request){
        $message->to($request->email);
        $message->subject('Reset Password Notification');
    });
    return $this->onSuccess();

 


 
    
 }


}
