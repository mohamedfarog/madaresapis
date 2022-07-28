<?php

namespace App\Http\Controllers;

use App\Models\SalaryType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalaryTypeController extends Controller
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
            return $this->onSuccess($salaryTypes = SalaryType::all('id', 'ar_title'));
        }
        else{
            return $this->onSuccess($salaryTypes = SalaryType::all('id', 'en_title'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        //validate the request
        $validator = Validator::make($request->all(),
            [
                'ar_title' => 'required|String',
                'en_title' => 'required|String',
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        //check the user
        $user = User::find(Auth::id());
        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $salaryType = SalaryType::create([
            'ar_title' => $request['ar_title'],
            'en_title' => $request['en_title'],
        ]);

        return $this->onSuccess('Salary Type added.');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //validate the request
        $validator = Validator::make($request->all(),
            [
                'id' => 'required',
                'ar_title' => 'required|String',
                'en_title' => 'required|String',
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        //check the user
        $user = User::find(Auth::id());
        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $salaryType = SalaryType::find($request['id']);
        if(!$salaryType){
            return $this->onSuccess('Salary Type with id: ' . $request['id'] . ' not found');
        }

        $salaryType->ar_title = $request['ar_title'];
        $salaryType->en_title = $request['en_title'];
        $salaryType->save();

        return $this->onSuccess('Salary Type updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        //validate the request
        $validator = Validator::make($request->all(),
            [
                'id' => 'required'
            ]);

        if($validator->fails()) {
            return $this->onError($validator->errors()->all());
        }

        //check the user
        $user = User::find(Auth::id());
        if ($user->is_active != 1 || $user->email_verified_at == NULL) {
            return $this->onError("Account is not verified", 400);
        }

        $salaryType = SalaryType::find($request['id']);
        if(!$salaryType){
            return $this->onSuccess('Salary Type with id: ' . $request['id'] . ' not found');
        }

        $salaryType->delete();

        return $this->onSuccess('Salary Type deleted.');
    }
}
