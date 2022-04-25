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

        $wave2 = new Wave();
        $wave2->Name = "Spark Delivery Wave 47B";
        $wave2->StartDate = "2022-04-22";
        $wave2->ItopsInspector = "SD";
        $wave2->Return = false;
        $wave2->IdProgram = 107;
        $wave2->save();

        $wave3 = new Wave();
        $wave3->Name = "Airbnb Wave 44";
        $wave3->StartDate = "2022-04-22";
        $wave3->ItopsInspector = "SD";
        $wave3->Return = false;
        $wave3->IdProgram = 104;
        $wave3->save();
    }
}
