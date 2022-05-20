<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

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
      
    }
}
