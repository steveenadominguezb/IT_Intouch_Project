<?php

namespace Database\Seeders;

use App\Models\Wave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WavesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wave1 = new Wave();
        $wave1->Name = "Booking CSG Spa Wave 29";
        $wave1->StartDate = "2022-04-22";
        $wave1->ItopsInspector = "SD";
        $wave1->Return = false;
        $wave1->IdProgram = 105;
        $wave1->save();
    }
}
