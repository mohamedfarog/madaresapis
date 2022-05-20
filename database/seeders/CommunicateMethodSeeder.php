<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jobs\CommunicateMethod;

class CommunicateMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email =  CommunicateMethod::create(['type'  =>'email' , 'contact' => 'info@madaras.ae']);
        $walkIn =  CommunicateMethod::create(['type'  =>'walk-in' , 'contact' => 'Hamdan Bin Mohammed St']);
        $phone =  CommunicateMethod::create(['type'  =>'phone' , 'contact' => '02 621 8400']);
    }
}
