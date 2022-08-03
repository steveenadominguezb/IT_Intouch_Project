<?php

namespace Database\Seeders;

use App\Models\Wave;
use App\Models\WaveLocation;
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
        $wave1->Name = "Booking CSP Spa Wave 16";
        $wave1->StartDate = "2022-05-06";
        $wave1->ItopsInspector = "CR";
        $wave1->IdProgram = 105;
        $wave1->save();

        $wave2 = new Wave();
        $wave2->Name = "Spark Delivery Wave 48B";
        $wave2->StartDate = "2022-05-06";
        $wave2->ItopsInspector = "CR";
        $wave2->IdProgram = 107;
        $wave2->save();

        $wave5 = new Wave();
        $wave5->Name = "Spark Delivery Wave Next";
        $wave5->StartDate = "2022-05-13";
        $wave5->ItopsInspector = "SD";
        $wave5->IdProgram = 107;
        $wave5->save();

        $wave3 = new Wave();
        $wave3->Name = "Airbnb Wave 43";
        $wave3->StartDate = "2022-04-21";
        $wave3->ItopsInspector = "SD";
        $wave3->IdProgram = 104;
        $wave3->save();

        $wave4 = new Wave();
        $wave4->Name = "Staff";
        $wave4->StartDate = "2022-01-01";
        $wave4->ItopsInspector = "SD";
        $wave4->IdProgram = 1;
        $wave4->save();

        $waveLocation = new WaveLocation();
        $waveLocation->IdWave = 5;
        $waveLocation->IdLocation = 101;
        $waveLocation->save();

        $waveLocation = new WaveLocation();
        $waveLocation->IdWave = 1;
        $waveLocation->IdLocation = 101;
        $waveLocation->save();

        $waveLocation = new WaveLocation();
        $waveLocation->IdWave = 2;
        $waveLocation->IdLocation = 101;
        $waveLocation->save();

        $waveLocation = new WaveLocation();
        $waveLocation->IdWave = 3;
        $waveLocation->IdLocation = 101;
        $waveLocation->save();

        $waveLocation = new WaveLocation();
        $waveLocation->IdWave = 4;
        $waveLocation->IdLocation = 101;
        $waveLocation->save();
    }
}
