<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobs\JobLevel;

class JobLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $preschool =  JobLevel::create(['title'  =>'preschool']);
        $early =  JobLevel::create(['title'  =>'early childhood']);
        $permanent =  JobLevel::create(['title'  =>'permanent']);
        $temporary =  JobLevel::create(['title'  =>'temporary']);
        $contract =  JobLevel::create(['title'  =>'contract']);
        $intrenship =  JobLevel::create(['title'  =>'intrenship']);
        $fresher =  JobLevel::create(['title'  =>'fresher']);
    }
}
