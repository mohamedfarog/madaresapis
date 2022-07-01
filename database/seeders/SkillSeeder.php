<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        for ($x = 0; $x <= 10; $x++) {
            DB::table('skill')->insert([
                'ar_skill_name' => Str::random(10),
                'en_skill_name' => Str::random(10),
            ]);
          }
     
    }
}
