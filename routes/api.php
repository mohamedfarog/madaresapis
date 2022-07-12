<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\CurriculumController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Job\JobLevelController;
use App\Http\Controllers\Job\JobTypeController;
use App\Http\Controllers\Website\QuestionedAnswersController as FAQController;
use App\Http\Controllers\Website\HomePageController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\TeachersController;
use App\Http\Controllers\Website\SubjectsControlle;
use App\Http\Controllers\Website\SchoolsController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Website\AcademyController;
use App\Http\Controllers\ResetPasswordController;
use App\Models\Gender;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('testFace', [AuthController::class, 'testFace']);
Route::post('testVerifyEmail', [RegisterController::class, 'testVerifyEmail']);
Route::get('verifyEmail/{token}', [RegisterController::class, 'verifyEmail']);
Route::group(['prefix' => 'job_type'], function () {
   Route::post('create',  [JobTypeController::class, 'create']);
   Route::get('get',  [JobTypeController::class, 'get']);
   Route::post('update',  [JobTypeController::class, 'update']);
   route::delete('delete/{id}', [JobTypeController::class, 'delete']);
});
Route::group(['prefix' => 'job_level'], function () {
   Route::post('create',  [JobLevelController::class, 'create']);
   Route::post("update",  [JobLevelController::class, 'update']);
   Route::get("get",  [JobLevelController::class, 'get']);
   Route::delete('destroy/{id}', [JobLevelController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});
 // Route::get('/', function () {
 //return response()->json('Madars-Backend'); 
 //})->name('login');
Route::group(['prefix' => 'auth'], function () {
   //Route::post('logout', [AuthController::class,'logout']);
   Route::post('refresh',  [AuthController::class, 'refresh']);
   Route::post('me',  [AuthController::class, 'me']);
});

Route::group(
   ['middleware' => ['jwt.verify']],
   function () {
      Route::get('/job/store', [JobController::class, 'store']);
   }
);
Route::get('testEmailTemplate', [RegisterController::class, 'testEmail']);
Route::post('register',  [RegisterController::class, 'register']);
Route::post('login', [AuthController::class, 'loginV2']);
Route::post('socialLogin', [AuthController::class, 'socialLogin']);
Route::post('type_to_null', [RegisterController::class, 'setTypeToNull']);
Route::post('userType', [RegisterController::class, 'UpdateUserType']);
Route::post('forget_password', [ForgotPasswordController::class, 'postEmail']);
//Route::post('re_send_verfiy', [ForgotPasswordController::class, 'reSendEmail']);
Route::post('reset_password', [ResetPasswordController::class, 'updatePassword']);
Route::post('re_send_verfiy', [RegisterController::class, 'reSendVerificationSendEmail']);
Route::post('check_verification', [RegisterController::class, 'returnEmailVerifyed']);
Route::get('dash_header_count', [AcademyController::class, 'getAcademyHeadercount']);
Route::get('received_applications', [AcademyController::class, 'AllRecivedApplications']);
Route::get('rejected_applications', [AcademyController::class, 'AllRejectedApplications']);
Route::get('interviwed_applications', [AcademyController::class, 'AllInterviwedApplications']);

Route::group(['prefix' => 'website'], function () {
Route::group(['middleware' => 'auth:sanctum'], function () {
//Route::post('/login', [AuthController::class, 'login']);
});
   Route::get('FAQ', [HomePageController::class, 'getFaqInfo']);
   Route::get('hpSubject', [HomePageController::class, 'getSubjectsTitle']);
   Route::post('articlesInfo', [HomePageController::class, 'getArticaleInfo']);
   Route::post('about', [AboutController::class, 'aboutData']);
   Route::post('joblevel', [HomePageController::class, 'returnJobLevel']);
   Route::post('HomeBanner', [HomePageController::class, 'getHomeBanner']);
   Route::get('AvailableJobs', [HomePageController::class, 'AvailableJobs']);
   Route::get('HpBannar', [HomePageController::class, 'homePageBanner']);
   Route::get('teacher', [TeachersController::class, 'teacherData']);
   Route::get('acadmy', [AcademyController::class, 'academyData']);
   Route::get('jobs', [JobController::class, 'getJobsInfo']);
   Route::post('register', [RegisterController::class, 'register']);
   Route::post('skills', [HomePageController::class, 'userSkills']);
   Route::post('available', [HomePageController::class, 'AvailableApplicant']);
   if (now()->diffInMinutes(session('lastActivityTime')) >= (120)) {
      //also you can this value in your config file and use here
      if (auth()->check() && auth()->id() > 1) {
         $user = auth()->user();
         auth()->logout();
         $user->update(['is_logged_in' => false]);
         $this->reCacheAllUsersData();
         session()->forget('lastActivityTime');
         return redirect(route('users.login'));
      }
   }
});
Route::get('/updates', function () {
   $output = shell_exec('cd ../ && git pull && php artisan migrate --force');
   echo "<pre>$output</pre>";;
});
