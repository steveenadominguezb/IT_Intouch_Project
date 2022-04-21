<?php

namespace Database\Seeders;

use App\Models\Monitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monitor1 = new Monitor();
        $monitor1->SerialNumber = "8DNTH13";
        $monitor1->Model = "E1916HV";
        $monitor1->Brand = "DELL";
        $monitor1->save();

        $monitor2 = new Monitor();
        $monitor2->SerialNumber = "72NTH13";
        $monitor2->Model = "E1916HV";
        $monitor2->Brand = "DELL";
        $monitor2->save();

        $monitor3 = new Monitor();
        $monitor3->SerialNumber = "40PGFS2";
        $monitor3->Model = "E2016H";
        $monitor3->Brand = "DELL";
        $monitor3->save();

        $monitor4 = new Monitor();
        $monitor4->SerialNumber = "7MPTH13";
        $monitor4->Model = "E1916HV";
        $monitor4->Brand = "DELL";
        $monitor4->save();

        $monitor5 = new Monitor();
        $monitor5->SerialNumber = "62XWG93";
        $monitor5->Model = "E1920H";
        $monitor5->Brand = "DELL";
        $monitor5->save();

        $monitor6 = new Monitor();
        $monitor6->SerialNumber = "62RXG93";
        $monitor6->Model = "E1920H";
        $monitor6->Brand = "DELL";
        $monitor6->save();
    }

}
