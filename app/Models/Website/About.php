<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jobs\Job;
use App\Models\Teachers\Teacher;
use App\Models\Academies\Academy;


class About extends Model
{

    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];



    public function totalJobs()
    {
        $jobs= Job::get()->count();
        return $jobs;
    }

    public function totalTeachers()
    {
        $teahers= Teacher::get()->count();
        return $teahers;
    }
    public function totalSchools()
    {
        $academy = Academy::get()->count();
        return $academy;
    }
    public function  totalAccepted(){
        return 0;
    }

}
