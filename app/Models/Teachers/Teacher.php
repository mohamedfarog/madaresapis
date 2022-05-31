<?php

namespace App\Models\Teachers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\TeacherResume;
use App\Models\Teachers\TeacherExperience;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Job\JobLevel;

class Teacher extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'first_name' , 'last_name','mobile' , 'date_of_birth' , 'avatar' , 'academic_major' , 'bio' , 'gender'  ];
    protected $guarded = ['id'];

    protected $hidden = ['updated_at'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    

    public function resume(): HasOne
    {
        return $this->hasOne(TeacherResume::class);
    }
    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class);
    }
    public function experiences(): HasMany
    {
        return $this->hasMany(TeacherExperience::class);
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
