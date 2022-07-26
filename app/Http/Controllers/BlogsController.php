<?php

namespace App\Http\Controllers;
use App\Models\Blogs;
use Illuminate\Http\Request;
use App\Models\Academies\Academy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function GuzzleHttp\Promise\all;

class BlogsController extends Controller
{
    
    public function createBlog(Request $request){

        $userId = Auth::id();
        $academyId = Academy::where('user_id', $userId)->first()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
      
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $blog = new Blogs();
        $blog->academy_id = $academyId;
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->save();
        return $this->onSuccess($blog);
    }

    public function getBlogs(){
        return $this->onSuccess(Blogs::all());
    }

}
