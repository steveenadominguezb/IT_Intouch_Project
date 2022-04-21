<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $component1 = new Component();
        $component1->IdComponent = 101;
        $component1->Description = "Mouse";
        $component1->Brand = "Generic";
        $component1->Quantity = 673;
        $component1->save();

        $component2 = new Component();
        $component2->IdComponent = 102;
        $component2->Description = "Keyboard";
        $component2->Brand = "Generic";
        $component2->Quantity = 759;
        $component2->save();

        $component3 = new Component();
        $component3->IdComponent = 103;
        $component3->Description = "Yubikey";
        $component3->Brand = "Generic";
        $component3->Quantity = 29;
        $component3->save();

        $component4 = new Component();
        $component4->IdComponent = 104;
        $component4->Description = "Yubikey 5 NFC";
        $component4->Brand = "Generic";
        $component4->Quantity = 210;
        $component4->save();

        $component5 = new Component();
        $component5->IdComponent = 105;
        $component5->Description = "Monitors";
        $component5->Brand = "Generic";
        $component5->Quantity = 748;
        $component5->save();

        $component6 = new Component();
        $component6->IdComponent = 106;
        $component6->Description = "Patch cords";
        $component6->Brand = "Generic";
        $component6->Quantity = 255;
        $component6->save();

        $component7 = new Component();
        $component7->IdComponent = 107;
        $component7->Description = "Power cables";
        $component7->Brand = "Generic";
        $component7->Quantity = 884;
        $component7->save();

        $component8 = new Component();
        $component8->IdComponent = 108;
        $component8->Description = "VGA cables";
        $component8->Brand = "Generic";
        $component8->Quantity = 646;
        $component8->save();

        $component9 = new Component();
        $component9->IdComponent = 109;
        $component9->Description = "DP cables";
        $component9->Brand = "Generic";
        $component9->Quantity = 156;
        $component9->save();

        $component10 = new Component();
        $component10->IdComponent = 110;
        $component10->Description = "HDMI cables";
        $component10->Brand = "Generic";
        $component10->Quantity = 212;
        $component10->save();

        $component11 = new Component();
        $component11->IdComponent = 111;
        $component11->Description = "DVI cables";
        $component11->Brand = "Generic";
        $component11->Quantity = 475;
        $component11->save();

        $component12 = new Component();
        $component12->IdComponent = 112;
        $component12->Description = "VGA/USB C cables";
        $component12->Brand = "Generic";
        $component12->Quantity = 145;
        $component12->save();

        $component13 = new Component();
        $component13->IdComponent = 113;
        $component13->Description = "USB type C to HDMI Adpater";
        $component13->Brand = "Generic";
        $component13->Quantity = 51;
        $component13->save();

        $component14 = new Component();
        $component14->IdComponent = 114;
        $component14->Description = "USB type C to VGA Adapter";
        $component14->Brand = "Generic";
        $component14->Quantity = 192;
        $component14->save();

        $component15 = new Component();
        $component15->IdComponent = 115;
        $component15->Description = "HDMI to VGA Adapter";
        $component15->Brand = "Generic";
        $component15->Quantity = 100;
        $component15->save();

        $component16 = new Component();
        $component16->IdComponent = 116;
        $component16->Description = "DP to VGA Adapter";
        $component16->Brand = "Generic";
        $component16->Quantity = 137;
        $component16->save();

        $component17 = new Component();
        $component17->IdComponent = 117;
        $component17->Description = "PVC BADGES";
        $component17->Brand = "Generic";
        $component17->Quantity = 335;
        $component17->save();

        $component18 = new Component();
        $component18->IdComponent = 118;
        $component18->Description = "CORDS BADGES";
        $component18->Brand = "Generic";
        $component18->Quantity = 199;
        $component18->save();

        $component19 = new Component();
        $component19->IdComponent = 119;
        $component19->Description = "PLASTIC COVER BADGES";
        $component19->Brand = "Generic";
        $component19->Quantity = 467;
        $component19->save();

        $component20 = new Component();
        $component20->IdComponent = 120;
        $component20->Description = "Desktops";
        $component20->Brand = "Generic";
        $component20->Quantity = 432;
        $component20->save();

        $component21 = new Component();
        $component21->IdComponent = 121;
        $component21->Description = "Laptops";
        $component21->Brand = "Generic";
        $component21->Quantity = 5;
        $component21->save();

        $component22 = new Component();
        $component22->IdComponent = 122;
        $component22->Description = "Chromeboxes";
        $component22->Brand = "Generic";
        $component22->Quantity = 311;
        $component22->save();

        $component23 = new Component();
        $component23->IdComponent = 123;
        $component23->Description = "Chromebooks";
        $component23->Brand = "Generic";
        $component23->Quantity = 3;
        $component23->save();
    }
}
