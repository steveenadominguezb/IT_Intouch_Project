<?php

namespace Database\Seeders;

use App\Models\Privilege;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $privilege1 = new Privilege();
        $privilege1->id = 10001;
        $privilege1->description = "Admin Privilege";
        $privilege1->save();
        
        $privilege2 = new privilege;
        $privilege2->id = 20001;
        $privilege2->description = "None Privilege";
        $privilege2->save();

        $privilege3 = new privilege;
        $privilege3->id = 30001;
        $privilege3->description = "IT Privilege";
        $privilege3->save();
    }
}
