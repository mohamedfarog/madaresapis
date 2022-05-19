<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $male =  Gender::create(['title'  =>'male']);
        $female =  Gender::create(['title'  =>'female']);
        $any =  Gender::create(['title'  =>'any']);
    }
}
