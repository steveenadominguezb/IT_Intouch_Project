<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $program1 = new Program();
        $program1->IdProgram = 101;
        $program1->Name = "TCP";
        $program1->img = "tcp.png";
        $program1->save();

        $program2 = new Program();
        $program2->IdProgram = 102;
        $program2->Name = "GNC";
        $program2->img = "gnc.png";
        $program2->save();

        $program3 = new Program();
        $program3->IdProgram = 103;
        $program3->Name = "Optavia";
        $program3->img = "optavia.jpg";
        $program3->save();

        $program4 = new Program();
        $program4->IdProgram = 104;
        $program4->Name = "Airbnb";
        $program4->img = "airbnb.png";
        $program4->save();

        $program5 = new Program();
        $program5->IdProgram = 105;
        $program5->Name = "Booking";
        $program5->img = "booking.png";
        $program5->save();

        $program6 = new Program();
        $program6->IdProgram = 106;
        $program6->Name = "L'Oreal";
        $program6->img = "l'oreal.jpg";
        $program6->save();

        $program7 = new Program();
        $program7->IdProgram = 107;
        $program7->Name = "Walmart Spark";
        $program7->img = "spark.png";
        $program7->save();

        $program8 = new Program();
        $program8->IdProgram = 108;
        $program8->Name = "Vroom";
        $program8->img = "vroom.jpg";
        $program8->save();

        $program9 = new Program();
        $program9->IdProgram = 109;
        $program9->Name = "Weber";
        $program9->img = "weber.jpg";
        $program9->save();

        $program10 = new Program();
        $program10->IdProgram = 110;
        $program10->Name = "Levis";
        $program10->img = "levis.png";
        $program10->save();

        $program11 = new Program();
        $program11->IdProgram = 1;
        $program11->Name = "24-7Intouch";
        $program11->img = "intouch.png";
        $program11->save();

        $program12 = new Program();
        $program12->IdProgram = 111;
        $program12->Name = "Mejuri";
        $program12->img = "mejuri.png";
        $program12->save();
    }
}
