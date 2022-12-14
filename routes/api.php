<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\JobMinimumExperienceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SalaryRateController;
use App\Http\Controllers\SalaryTypeController;
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
use App\Http\Controllers\HelpController;
use App\Http\Controllers\BlogsController;

use App\Http\Controllers\Website\AcademyController;
use App\Http\Controllers\Website\YearsOfTeachingController;
use App\Http\Controllers\ResetPasswordController;
use App\Models\AcademySize;
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
//Test API's
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
Route::group(['
' => 'auth'], function () {
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
Route::post('forget_password', [ForgotPasswordController::class, 'postEmail']);
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
   Route::post('tested', [JobController::class, 'testHtml']);

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
   Route::get('jobs', [HomePageController::class, 'gteAllJobs']);
   Route::post('register', [RegisterController::class, 'register']);
   Route::post('skills', [HomePageController::class, 'userSkills']);
   Route::post('testyy', [HomePageController::class, 'testingHtttpRequest']);
   Route::post('get_job_type', [HomePageController::class, 'getJobType']);


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

Route::group(['middleware' => 'auth:api'], function () {
   // ----------------------USER------------------------------------------
   Route::post('follow_user', [AuthController::class, 'followUser']);
   Route::post('unfollow_user', [AuthController::class, 'unfollowUser']);
   Route::post('update_my_info', [AuthController::class, 'updateMyInfo']);
   Route::post('userType', [RegisterController::class, 'UpdateUserType']);
   Route::get('my_info', [AuthController::class, 'my_info']);
   Route::post('send_help_request', [HelpController::class, 'sendHelpRequest']);
   Route::get('search_teachers', [RegisterController::class, 'search_teachers']);
   Route::get('teacher_info/{id}', [RegisterController::class, 'teacher_info']);

   Route::get('analytics', [AnalyticsController::class, 'getApplicationStats']);

   Route::post('years_of_teaching', [AcademyController::class, 'academyYearsOfTeaching']);
   Route::post('academy_size', [AcademyController::class, 'academySize']);

   // ----------------------JOB------------------------------------------
   Route::post('create_new_job', [JobController::class, 'addJob']);

   Route::get('get_my_jobs', [JobController::class, 'get_my_jobs']);
   Route::get('search_for_job', [JobController::class, 'searchJobPost']);
   Route::post('updateStatus', [JobController::class, 'updateStatus']);

   Route::post('apply_for_job', [JobController::class, 'applyForJob']);
   Route::post('delete_job', [JobController::class, 'deleteJob']);
   Route::get('teacherApplications', [JobController::class, 'teacherApplications']);


   // ---------------------- APPLICATION------------------------------------------



   // ---------------------- USER FOLLOWS------------------------------------------


   //--------------------------Blogs----------------------------------------------
   Route::post('add_blogs', [BlogsController::class, 'createBlog']);
   Route::get('get_blogs', [BlogsController::class, 'getBlogs']);
   Route::post('update_blogs', [BlogsController::class, 'updateBlogs']);

   Route::post('delete_blogs', [BlogsController::class, 'deletetBlogs']);

   Route::post('delete_teacher_file', [TeachersController::class, 'deleteTeacherFile']);
   Route::post('update_teacher_file', [TeachersController::class, 'updateTeacherFile']);
   Route::get('get_teacher_files', [TeachersController::class, 'getAllFilesForThisTeacher']);

   Route::post('delete_academy_files', [AcademyController::class, 'deleteAcademyFile']);
   Route::post('update_academy_files', [AcademyController::class, 'updateAcademyFile']);
   Route::get('get_academy_files', [AcademyController::class, 'getAcademyFile']);


   Route::post('update_academy_avatar', [RegisterController::class, 'updateAcademyAvatar']);
   Route::post('update_teacher_avatar', [RegisterController::class, 'updateTeacherAvatar']);




   //--------------------------Message-----------------------------------
   Route::post('sendMessage', [MessageController::class, 'sendMessage']);
   Route::get('getMessages', [MessageController::class, 'getMessages']);
   Route::delete('deleteMessage', [MessageController::class, 'deleteMessage']);
   Route::post('seenMessage', [MessageController::class, 'seenMessage']);
   //---------------------------------------------------------------------

    //-----------------------------Job Minimum Experience-----------------------------------
    Route::group(['prefix' => 'jobMinimumExperience'], function () {
        Route::post('/', [JobMinimumExperienceController::class, 'index']);
        Route::post('/store', [JobMinimumExperienceController::class, 'store']);
        Route::put('/update', [JobMinimumExperienceController::class, 'update']);
        Route::delete('/destroy', [JobMinimumExperienceController::class, 'destroy']);
    });
    //--------------------------------------------------------------------------------------

    //---------------------------------Salary Rate------------------------------------------
    Route::group(['prefix' => 'salaryRate'], function () {
        Route::post('/', [SalaryRateController::class, 'index']);
        Route::post('/store', [SalaryRateController::class, 'store']);
        Route::put('/update', [SalaryRateController::class, 'update']);
        Route::delete('/destroy', [SalaryRateController::class, 'destroy']);
    });
    //--------------------------------------------------------------------------------------

    //------------------------------------Salary Type---------------------------------------
    Route::group(['prefix' => 'salaryType'], function () {
        Route::post('/', [SalaryTypeController::class, 'index']);
        Route::post('/store', [SalaryTypeController::class, 'store']);
        Route::put('/update', [SalaryTypeController::class, 'update']);
        Route::delete('/destroy', [SalaryTypeController::class, 'destroy']);
    });
    //--------------------------------------------------------------------------------------



   Route::post('update_application_status', [JobController::class, 'update_applicationStatus']);
   Route::get('get_applications ', [JobController::class, 'getAllApplications']);
});

// ----------------------PUBLIC API------------------------------------------
Route::get('get_available_jobs', [JobController::class, 'get_available_jobs']);
Route::get('all_academy_sizes', function () {
   return AcademySize::all();
});

//Updates
Route::get('activate_job', [JobController::class, 'activateAJob']);



