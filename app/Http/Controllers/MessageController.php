<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{


    public function sendMessage(Request $request){

        //validate the request
        $validator = Validator::make($request->all(),
        [
            'to' => 'required|Integer',
            'subject' => 'required|String',
            'content' => 'required|String'
        ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        //get the from user
        $userFrom = User::find(Auth::id());
        if ($userFrom->is_active != 1 || $userFrom->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        // get the to user
        $userTo = User::find($request['to']);
        if($userTo == null){
            return $this->onError("The receiver user in not exist", 400);
        }

        //save the message
        $message = Message::create([
            'from' => $userFrom->id,
            'to' => $userTo->id,
            'subject' => $request['subject'],
            'content' => $request['content'],
            'sending_date' => Carbon::now()->timezone('Asia/Riyadh')
        ]);

        //return the response
        return $this->onSuccess(["content" => $message->content]);
    }


    public function getMessages(){

        $user = User::find(Auth::id());

        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $messages = Message::select('id', 'from', 'to', 'subject', 'content', 'sending_date')
            ->where('from',$user->id)->orwhere('to', $user->id)
            ->paginate()->toArray();

        return $this->onSuccess($messages);
    }

    public function seenMessage(Request $request){
        //validate the request
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|Integer'
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        //get the user
        $user = User::find(Auth::id());
        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $message = Message::find($request['id']);
        if($message == null){
            return $this->onError("Message not found");
        }

        $message->seen = 1;
        $message->seen_date = Carbon::now()->timezone('Asia/Riyadh');
        $message->save();

        return $this->onSuccess("Message seen");

    }


    public function deleteMessage(Request $request){

        //validate the request
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|Integer'
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }


        $user = User::find(Auth::id());

        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $message =  Message::where('id', $request->id )->first();
        if ($message == null){
            return $this->onError('Message is not exist');
        }
        $message->delete();
        return $this->onSuccess('Message has been deleted');

    }

}
