<?php

namespace Database\Seeders;

use App\Models\Computer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $computer1 = new Computer();
        $computer1->SerialNumber = "9X90PY2";
        $computer1->HostName = "BOG1-WFH-3086";
        $computer1->Model = "Optiplex 3060";
        $computer1->OS = "Windows";
        $computer1->Brand = "DELL";
        $computer1->save();        

        $computer2 = new Computer();
        $computer2->SerialNumber = "64VWRB3";
        $computer2->HostName = "BOG1-WFH-3723";
        $computer2->Model = "Optiplex 3080";
        $computer2->OS = "Windows";
        $computer2->Brand = "DELL";
        $computer2->save();      

        $computer3 = new Computer();
        $computer3->SerialNumber = "13M7H63";
        $computer3->HostName = "BOG1-WFH-3134";
        $computer3->Model = "Optiplex 3070";
        $computer3->OS = "Windows";
        $computer3->Brand = "DELL";
        $computer3->save();      

        $computer4 = new Computer();
        $computer4->SerialNumber = "16L5H63";
        $computer4->HostName = "BOG1-WFH-3429";
        $computer4->Model = "Optiplex 3070";
        $computer4->OS = "Windows";
        $computer4->Brand = "DELL";
        $computer4->save();      

        $computer5 = new Computer();
        $computer5->SerialNumber = "9JGX7X2";
        $computer5->HostName = "BOG1-WFH-2344";
        $computer5->Model = "Optiplex 3060";
        $computer5->OS = "Windows";
        $computer5->Brand = "DELL";
        $computer5->save();
        
        $computer6 = new Computer();
        $computer6->SerialNumber = "9R44PY2";
        $computer6->HostName = "BOG1-WFH-3115";
        $computer6->Model = "Optiplex 3060";
        $computer6->OS = "Windows";
        $computer6->Brand = "DELL";
        $computer6->save();        

        $computer7 = new Computer();
        $computer7->SerialNumber = "JYTWRB3";
        $computer7->HostName = "BOG1-WFH-3714";
        $computer7->Model = "Optiplex 3080";
        $computer7->OS = "Windows";
        $computer7->Brand = "DELL";
        $computer7->save();      

        $computer8 = new Computer();
        $computer8->SerialNumber = "86VWRB3";
        $computer8->HostName = "BOG1-WFH-3711";
        $computer8->Model = "Optiplex 3080";
        $computer8->OS = "Windows";
        $computer8->Brand = "DELL";
        $computer8->save();      

        $computer9 = new Computer();
        $computer9->SerialNumber = "1J1L613";
        $computer9->HostName = "BOG1-WFH-3301";
        $computer9->Model = "Optiplex 3070";
        $computer9->OS = "Windows";
        $computer9->Brand = "DELL";
        $computer9->save();      

        $computer10 = new Computer();
        $computer10->SerialNumber = "BCSL423";
        $computer10->HostName = "BOG1-WFH-3369";
        $computer10->Model = "Optiplex 3070";
        $computer10->OS = "Windows";
        $computer10->Brand = "DELL";
        $computer10->save();

    }
}
