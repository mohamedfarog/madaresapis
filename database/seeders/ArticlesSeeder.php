<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++){
            DB::table('articles')->insert([ 
                'title' =>Str::random(13),
                'body' =>Str::random(13),
                'owner_name' => Str::random(13),
                'ar_owner_name' => Str::random(13),
                'ar_title' =>Str::random(13),
                'ar_body' =>Str::random(13)
            ]);
        }
    }
}