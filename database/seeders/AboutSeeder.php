<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 3; $i++){
        DB::table('abouts')->insert([
            'ar_title' => Str::random(13),
            'ar_body' =>Str::random(13),
            'ar_name' => Str::random(13),
           
        ]);
    }

}
}
