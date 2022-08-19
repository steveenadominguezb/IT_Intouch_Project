<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location1 = new Location();
        $location1->IdLocation = 101;
        $location1->Name = "Bogotá";
        $location1->save();
        
        $location2 = new Location();
        $location2->IdLocation = 201;
        $location2->Name = "Medellín";
        $location2->save();
        
        $location3 = new Location();
        $location3->IdLocation = 301;
        $location3->Name = "Bucaramanga";
        $location3->save();
        
        $location4 = new Location();
        $location4->IdLocation = 401;
        $location4->Name = "Barranquilla";
        $location4->save();
        
        $location5 = new Location();
        $location5->IdLocation = 501;
        $location5->Name = "Cali";
        $location5->save();

        $location6 = new Location();
        $location6->IdLocation = 601;
        $location6->Name = "Sogamoso";
        $location6->save();

        $location7 = new Location();
        $location7->IdLocation = 701;
        $location7->Name = "Tunja";
        $location7->save();
        
        $location8 = new Location();
        $location8->IdLocation = 801;
        $location8->Name = "Duitama";
        $location8->save();

        $location9 = new Location();
        $location9->IdLocation = 901;
        $location9->Name = "Boyaca";
        $location9->save();
    }
}
