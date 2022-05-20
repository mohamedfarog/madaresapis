<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Teachers\Teacher;
use App\Models\Role;
use App\Models\Academies\Academy;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

       

        $adminTest =  User::create([
            'name'  =>'Ahmed Admin Role',
            'email' => 'admin@madars.com',
            'password' => Hash::make('password')]);

        $teacherTest =  User::create([
            'name'  =>'Ahmed Teacher Role',
            'email' => 'teacher@madars.com',
            'password' => Hash::make('password')]);

        $academyTest =  User::create([
            'name'  =>'Ahmed Academy Role',
            'email' => 'academy@madars.com',
            'password' => Hash::make('password')]);

     

        $adminRole = Role::where('name','admin')->first();
        $teacherRole = Role::where('name','teacher')->first();
        $academyRole = Role::where('name','academy')->first();
      
        $adminTest->roles()->attach($adminRole);
        $teacherTest->roles()->attach($teacherRole);
        $academyTest->roles()->attach($academyRole);


        $teachers = User::factory(10)->create()->each(function ($user) use ($teacherRole) {
         
           $user->roles()->attach($teacherRole);
            
           $teacher = Teacher::factory(1)->make();

           $user->teachers()->saveMany($teacher);
          
           
        });

        $academies = User::factory(10)->create()->each(function ($user) use ($academyRole) {
         
           $user->roles()->attach($academyRole);
            
           $Academy = Academy::factory(1)->make();

           $user->academies()->saveMany($Academy);
          
           
        });
      
    }
}
