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
        $wave1->Name = "24-7 Intouch Staff";
        $wave1->StartDate = "2020-01-01";
        $wave1->ItopsInspector = "IH";
        $wave1->IdProgram = 1;
        $wave1->save();

        $wave2 = new Wave();
        $wave2->Name = "TCP Staff";
        $wave2->StartDate = "2020-03-25";
        $wave2->ItopsInspector = "IH";
        $wave2->IdProgram = 101;
        $wave2->save();

        $wave3 = new Wave();
        $wave3->Name = "GNC Staff";
        $wave3->StartDate = "2020-05-9";
        $wave3->ItopsInspector = "IH";
        $wave3->IdProgram = 102;
        $wave3->save();

        $wave4 = new Wave();
        $wave4->Name = "Optavia Staff";
        $wave4->StartDate = "2020-08-22";
        $wave4->ItopsInspector = "IH";
        $wave4->IdProgram = 103;
        $wave4->save();

        $wave5 = new Wave();
        $wave5->Name = "Airbnb Staff";
        $wave5->StartDate = "2020-09-19";
        $wave5->ItopsInspector = "IH";
        $wave5->IdProgram = 104;
        $wave5->save();

        $wave6 = new Wave();
        $wave6->Name = "Booking Staff";
        $wave6->StartDate = "2020-03-14";
        $wave6->ItopsInspector = "IH";
        $wave6->IdProgram = 105;
        $wave6->save();

        $wave7 = new Wave();
        $wave7->Name = "L'Oreal Staff";
        $wave7->StartDate = "2020-03-15";
        $wave7->ItopsInspector = "IH";
        $wave7->IdProgram = 106;
        $wave7->save();

        $wave8 = new Wave();
        $wave8->Name = "Walmart Spark Staff";
        $wave8->StartDate = "2021-04-23";
        $wave8->ItopsInspector = "IH";
        $wave8->IdProgram = 107;
        $wave8->save();

        $wave9 = new Wave();
        $wave9->Name = "Vroom Staff";
        $wave9->StartDate = "2020-06-18";
        $wave9->ItopsInspector = "IH";
        $wave9->IdProgram = 108;
        $wave9->save();

        $wave10 = new Wave();
        $wave10->Name = "Weber Staff";
        $wave10->StartDate = "2020-05-09";
        $wave10->ItopsInspector = "IH";
        $wave10->IdProgram = 109;
        $wave10->save();

        $wave11 = new Wave();
        $wave11->Name = "Levis Staff";
        $wave11->StartDate = "2022-01-26";
        $wave11->ItopsInspector = "IH";
        $wave11->IdProgram = 110;
        $wave11->save();

        $wave12 = new Wave();
        $wave12->Name = "Mejuri Staff";
        $wave12->StartDate = "2020-03-19";
        $wave12->ItopsInspector = "IH";
        $wave12->IdProgram = 111;
        $wave12->save();

        $wave13 = new Wave();
        $wave13->Name = "Red Robin Staff";
        $wave13->StartDate = "2022-09-05";
        $wave13->ItopsInspector = "IH";
        $wave13->IdProgram = 112;
        $wave13->save();

        for ($i = 1; $i <= 12; $i++) {
            for ($j = 101; $j <= 501; $j = $j + 100) {
                $waveLocation = new WaveLocation();
                $waveLocation->IdWave = $i;
                $waveLocation->IdLocation = $j;
                $waveLocation->save();
            }
        }
    }
}
