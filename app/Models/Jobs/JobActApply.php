<?php

namespace App\Models\Jobs;

use App\Models\Academies\Academy;
use App\Models\Jobs\Job;
use App\Models\Teachers\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobActApply extends Model
{
    protected $table = 'job_act_apply';
    protected $appends = ['job_status'];
    use HasFactory;

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }
    public function jobs(): BelongsTo
    {
        return $this->belongsTo(Job::class, "job_id", 'id');
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, "teacher_id", 'id');
    }
    public function getJobStatusAttribute()
    {    
        switch ($this->status) {
            case 0:
                return 'Applied';
                break;
            case 1:
                return 'Pending';
                break;
            case 2:
                return 'Viewed';
                break;
            case 3:
                return 'Shortlisted';
                break;
            case 4:
                return 'Rejected';
                break;
            case 5:
                return 'Contacted';
                break;
            case 6:
                return 'Interviewed';
                break;
            case 7:
                return 'On Hold';
                break;
            case 8:
                return 'Accepted';
                break;
            default:
                return 'Awaiting';
                break;
        }
    }
}
