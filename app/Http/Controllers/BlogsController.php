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
            'like_unlike' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $blog = new Blogs();
        $blog->academy_id = $academyId;
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->like_unlike = $request->like_unlike;
        $blog->save();
        return $this->onSuccess($blog);
    }

    public function updateBlogs(Request $request){
        $userId = Auth::id();
        $academyId = Academy::where('user_id', $userId)->first()->id;
        $blog =  Blogs::where('academy_id', $academyId )->first();
        if (isset($request->title)){
            $blog->title = $request->title;
            
        }
        if (isset($request->body)){
            $blog->body = $request->body;

        }
        if (isset($request->like_unlike)){
            $blog->like_unlike = $request->like_unlike;
        }
        $blog->save();
 
        return $this->onSuccess($blog);
    }

    public function getBlogs(){
        return $this->onSuccess(Blogs::all());
    }
    public function deletetBlogs(Request $request){
        $userId = Auth::id();
        $academyId = Academy::where('user_id', $userId)->first()->id;
        $blog =  Blogs::where('id', $academyId )->first();
        $blog->delete();
        return $this->onSuccess('Blog has been deleted');
     
    }

}
