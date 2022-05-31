<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jobs\Job;
use App\Models\Teachers\Teacher;
use App\Models\Schools;


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
        $schools = Schools::get()->count();
        return $schools;
    }
    public function  totalAccepted(){
        return 0;
    }

}
