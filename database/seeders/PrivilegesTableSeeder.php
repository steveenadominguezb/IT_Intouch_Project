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
        $privilege1->description = "Admin Privileges";
        $privilege1->save();
        
        $privilege2 = new privilege;
        $privilege2->id = 20001;
        $privilege2->description = "None Privileges";
        $privilege2->save();

        $privilege3 = new privilege;
        $privilege3->id = 30001;
        $privilege3->description = "IT Privileges";
        $privilege3->save();

        $privilege5 = new privilege;
        $privilege5->id = 50001;
        $privilege5->description = "HR Privileges";
        $privilege5->save();

        $privilege4 = new privilege;
        $privilege4->id = 40001;
        $privilege4->description = "Agent Privileges";
        $privilege4->save();

        $privilege6 = new privilege;
        $privilege6->id = 60001;
        $privilege6->description = "Support Privileges";
        $privilege6->save();
    }
}
