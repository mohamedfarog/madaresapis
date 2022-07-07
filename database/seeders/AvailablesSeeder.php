<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



use Illuminate\Database\Seeder;

class AvailablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++){
            DB::table('availables')->insert([
                'en_text' => Str::random(13),
                'ar_text' =>Str::random(13)
            ]);
        }
      
    }
}
