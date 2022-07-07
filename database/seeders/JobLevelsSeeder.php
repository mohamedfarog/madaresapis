<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JobLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<= 5; $i++){
            DB::table('job_levels')->insert([
                'title' => Str::random(10),
                'avater' => Str::random(10),
                'ar_title' => Str::random(10),
            ]);

        }
         
    }
}
