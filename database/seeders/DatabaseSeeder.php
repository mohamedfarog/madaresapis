<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Website\QuestionedAnswers as FAQ;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    
        $this->call(UsersTableSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(CommunicateMethodSeeder::class);
        $testUser = FAQ::factory(8)->create();
        // $testUser = User::factory(10)->create();
       
    }
}
