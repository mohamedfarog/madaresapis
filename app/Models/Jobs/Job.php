<?php

namespace App\Models\Jobs;
use App\Models\Gender;
use App\Models\SalaryRate;
use App\Models\SalaryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Academies\Academy;
use App\Models\Jobs\JobType;
use App\Models\Jobs\JobLevel;
// use App\Models\Jobs\JobAppSetting;
use App\Models\Jobs\JobActApply;
use App\Models\Website\subjects;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{

    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = [ 'updated_at', 'deleted_at'];
    protected $appends=['job_status'];

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }
    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class, 'id', 'gender');
    }
    public function type(): HasOne
    {
        return $this->hasOne(JobType::class,'id',"job_subject_id");
    }
    public function level(): HasOne
    {
        return $this->hasOne(JobLevel::class,'id',"edu_level_id");
    }

    public function subjects(): HasOne
    {
        return $this->hasOne(subjects::class,'id','job_subject_id');
    }
    public function applications(): HasMany
    {
        return $this->HasMany(JobActApply::class);
    }
    public function awaiting(): HasMany
    {
        return $this->HasMany(JobActApply::class)->where('status',0);
    }
    public function reviewed(): HasMany
    {
        return $this->HasMany(JobActApply::class)->where('status',1);
    }
    public function contacting(): HasMany
    {
        return $this->HasMany(JobActApply::class)->where('status',2);
    }
    public function rejected(): HasMany
    {

        return $this->HasMany(JobActApply::class)->where('status',3);
    }
    public function hiredApplicants(): HasMany
    {
        return $this->HasMany(JobActApply::class)->where('status',4);
    }

    public function jobMinimumExperience(): HasOne
    {
        return $this->hasOne(JobMinimumExperience::class, 'id', 'min_exp_id')->select('id', 'title');
    }

    public function jobSalaryType(): HasOne
    {
        return $this->hasOne(SalaryType::class, 'id', 'min_exp_id')->select('id', 'title');
    }

    public function jobSalaryRate(): HasOne
    {
        return $this->hasOne(SalaryRate::class, 'id', 'salary_rate_id')->select('id', 'title');
    }

    public function getAcademiesInfoAttribute()
    {
        $academy = Academy::select('en_name', 'avatar', 'ar_name')->where('id', $this->id)->get();
        return $academy;
    }
    public function getJobStatusAttribute()
    {



            switch ($this->status) {
                case 0:
                    return 'Awaiting';
                    break;
                case 1:
                    return 'Reviewed';
                    break;
                case 2:
                    return 'Contacting';
                    break;
                case 3:
                    return 'Rejected';
                    break;
                case 4:
                    return 'Hired';
                    break;
                default:
                     return 'Awaiting';
                     break;



        }
    }
}
