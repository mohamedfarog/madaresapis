<?php

namespace App\Http\Controllers;

use App\Mail\HelpAcknowledgement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HelpController extends Controller
{
    public function sendHelpRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            "email" => "required|email",
            "subject" => "required",
            "mobile" => "required",
            "body" => "required",
        ]);

        if ($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }
        Mail::to($request->email)->cc(['faisal@mvp-apps.ae'])->send(new HelpAcknowledgement($request->all()));
        // return view('emails/email-help');
        return  $this->onSuccess(['message' => 'emails/email-help']);
    }
}
