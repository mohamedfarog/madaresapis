<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobs\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $full =  JobType::create(['title'  =>'full-time']);
        $female =  JobType::create(['title'  =>'part-time']);
        $permanent =  JobType::create(['title'  =>'permanent']);
        $temporary =  JobType::create(['title'  =>'temporary']);
        $contract =  JobType::create(['title'  =>'contract']);
        $intrenship =  JobType::create(['title'  =>'intrenship']);
        $fresher =  JobType::create(['title'  =>'fresher']);
    }
}
