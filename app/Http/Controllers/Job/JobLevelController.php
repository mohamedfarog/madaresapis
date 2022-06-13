<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobLevelController extends Controller
{
    //
    public function testUpload(Request $request)
    {
        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();


            return response()->json([
                "success" => true,
                "path" => $path,
                "name" => $name
            ]);
        }
    }
}
