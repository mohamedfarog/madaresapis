<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
   return response()->json('Madars-Backend'); 
})->name('login');

Route::group(['prefix' => 'auth'], function (){

   Route::post('login', [AuthController::class,'login']);
   Route::post('logout', [AuthController::class,'logout']);
   Route::post('refresh',  [AuthController::class,'refresh']);
   Route::post('me',  [AuthController::class,'me']);
   Route::post('register',  [RegisterController::class,'register']);

});



Route::group(['prefix' => 'website'], function () {

   
  
});


