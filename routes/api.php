<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\CurriculumController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Website\QuestionedAnswersController as FAQController;
use App\Http\Controllers\Website\HomePageController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\TeachersController;
use App\Http\Controllers\Website\SubjectsControlle ;
use App\Http\Controllers\Website\SchoolsController;
use App\Http\Controllers\Website\JobController;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   });
// Route::get('/', function () {
//    return response()->json('Madars-Backend'); 
// })->name('login');
Route::group(['prefix' => 'auth'], function (){
  // Route::post('logout', [AuthController::class,'logout']);
   Route::post('refresh',  [AuthController::class,'refresh']);
   Route::post('me',  [AuthController::class,'me']);
   Route::post('register',  [RegisterController::class,'register']);
});
   Route::group(['prefix' => 'website'], function () {
      Route::group(['middleware'=>'auth:sanctum'],function(){
      Route::post('/about',[AboutController::class, 'aboutData']);
      Route::post('/login', [AuthController::class,'login']);
});
   Route::post('FAQ',[HomePageController::class, 'getFaqInfo']);
   Route::post('hpSubject',[ HomePageController::class, 'getSubjectsTitle']);
   Route::post('articlesInfo',[ HomePageController::class, 'getArticaleInfo']);
   Route::post('joblevel',[ HomePageController::class, 'returnJobLevel']);
   Route::post('HomeBanner',[HomePageController::class, 'getHomeBanner']);
   Route::post('AvailableJobs',[HomePageController::class, 'AvailableJobs']);
   Route::post('HpBannar',[HomePageController::class, 'homePageBanner']);
   Route::post('teacher',[TeachersController::class, 'teacherData']);
   Route::post('school',[SchoolsController::class, 'schoolData']);
   Route::post('acadmy',[AcademyController::class, 'academyData']);
   Route::post('jobs',[JobController::class, 'getJobsInfo']);
   Route::post('register',[RegisterController::class, 'register']);
   Route::put('userType/{id}', [RegisterController::class, 'UpdateUserType']);
   Route::post('login',[AuthController::class, 'login']);
   if (now()->diffInMinutes(session('lastActivityTime')) >= (120) ) {  // also you can this value in your config file and use here
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
