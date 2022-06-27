<?php

namespace App\Models\Teachers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Locations;
use App\Models\Skills;
use App\Models\Availability;
use App\Models\Teachers\TeacherResume;
use App\Models\Teachers\TeacherExperience;
use App\Models\Teachers\TeacherEducation;
use App\Models\Teachers\TeacherFiles;
use App\Models\Job\JobLevel;


class Teacher extends Model
{
    use HasFactory;

     protected $fillable = ['user_id', 'en_first_name' , 'en_first_name','ar_first_name','ar_last_name', 'willing_to_travel',
     'date_of_birth' , 'avatar' , 'academic_major' , 'en_bio', 'ar_bio' , 'gender_id', 'job_level_id', 'availability_id', 'contact_number'];
    protected $guarded = ['id'];

    protected $hidden = ['created_id', 'updated_at'];

    public function getAvatarAttribute($value){
        return "http://api.madaresweb.mvp-apps.ae".$value;
    }   
    public function teacherLocations(): HasOne
    {
        return $this->HasOne(Locations::class, 'teacher_id', 'user_id');
    }
    public function resumes(): HasOne
    {
        return $this->hasOne(TeacherResume::class,'teacher_id', 'user_id');
    }
    
    public function teacherSkills(): HasMany
    {
        return $this->HasMany(Skills::class,'teacher_id', 'user_id');
    }
    public function teacherAvailabity(): HasOne
    {
        return $this->HasOne(Availability::class, 'teacher_id', 'user_id');
    }
    public function experiences(): HasMany
    {
   
        return $this->hasMany(TeacherExperience::class,'teacher_id', 'user_id');
    }
    public function education(): HasMany
    {
   
        return $this->hasMany(TeacherEducation::class,'teacher_id', 'user_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function teacherFiles(): HasMany
    {
        return $this->hasMany(TeacherFiles::class, 'academy_id', 'user_id');
    }
    

    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class);
    }
  
    public function level(): HasOne
    {
        return $this->hasOne(JobLevel::class);
    }
    
    public function getExperienceAttribute(){

        $start_day = TeacherExperience::where('teacher_id',$this->id)->first()->start_day;
        $end_day = TeacherExperience::where('teacher_id',$this->id)->first()->end_day;
        $exp = TeacherExperience::whereBetween('end_day', [$start_day, $end_day])->count();
        return $exp;
    }
}
