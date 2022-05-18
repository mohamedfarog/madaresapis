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
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(QuestionedAnswersSeeder::class);
        $testUser = FAQ::factory(8)->create();
        // $testUser = User::factory(10)->create();
       
    }
}
