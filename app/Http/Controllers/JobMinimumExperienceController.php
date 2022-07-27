<?php

namespace App\Http\Controllers;

use App\Models\Jobs\JobMinimumExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobMinimumExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //validate the request
        $validator = Validator::make($request->all(),
            [
                'language' => 'required|Integer',
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        if($request['language'] == '1'){
            return $this->onSuccess($jobMinimumExperiences = JobMinimumExperience::all('id', 'ar_title'));
        }
        else{
            return $this->onSuccess($jobMinimumExperiences = JobMinimumExperience::all('id', 'en_title'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
