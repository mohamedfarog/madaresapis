<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobTypeController extends Controller
{
  
    public function create(Request $request)
    {
        //return $request->ar_title;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $jobType = new JobType();
        $jobType->title = $request->title;
        $jobType->save();
        return $this->onSuccess($jobType, 200, "job type added successfully");
    }

    public function get()
    {
        $jobTypes = JobType::paginate(15);
        return $jobTypes;
    }

    public function update(Request $request)
    {
        $jobType = JobType::find($request->jobTypeId);
        if (!$jobType) {
            $this->onError("job type not found");
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $jobType->title = $request->title;
        $jobType->save();
        return $this->onSuccess($jobType, 200, "job type updated successfully successfully");
    }

    public function delete($id)
    {
        $jobType = JobType::find($id);
        if (!$jobType) {
            return $this->onError("job type not found");
        }
        $jobType->delete();
        return $this->onSuccess($jobType, 200, "job type deleted successfully successfully");
    }
}
