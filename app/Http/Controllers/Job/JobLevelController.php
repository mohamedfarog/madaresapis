<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobLevel;
use Illuminate\Http\Request;
use App\Traits\fileUpload;
use Illuminate\Support\Facades\Validator;

class JobLevelController extends Controller
{
    //
 

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'title' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $jobLevel = JobLevel::find($request->job_id);
        if (!$jobLevel) {
            return $this->onError("job level not found");
        }
        if ($file = $request->file('file')) {
            $icon = $this->uploadFile($file, 'job_level_icons');
            $jobLevel->avater = $icon;
        }
        $jobLevel->title = $request->title;
        $jobLevel->save();
        return $this->onSuccess($jobLevel, 200, "job level updated successfully!");
    }
    public function get()
    {
        $joblevels = JobLevel::get();
        return $this->onSuccess($joblevels, 200, "job level added successfully!");
    }
    public function destroy($id)
    {
        $jobLevel = JobLevel::find($id);
        if (!$jobLevel) {
            return $this->onError("job level not found");
        }
        $jobLevel->delete();
        return $this->onSuccess($jobLevel, 200, "job level deleted successfully!");
    }
}
