<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->cde = "C220631";
        $user1->name = "Steveen Dominguez";
        $user1->position = "IT Intern";
        $user1->username = "steveen.dominguez";
        $user1->password = Hash::make('!ntouch247');
        $user1->email = "steveen.dominguez@24-7intouch.com";
        $user1->ContactInfo = "+573224660181";
        $user1->status = "Active";
        $user1->privilege = 30001;
        $user1->save();
        
        $user2 = new User();
        $user2->cde = "C000001";
        $user2->name = "Administrator";
        $user2->position = "Administrator";
        $user2->username = "admin.it";
        $user2->password = Hash::make('!ntouch247');
        $user2->email = "admin.it@24-7intouch.com";
        $user2->ContactInfo = "+5730000001";
        $user2->status = "Active";
        $user2->privilege = 10001;
        $user2->save();

        $user3 = new User();
        $user3->cde = "C0000002";
        $user3->name = "Dumy";
        $user3->position = "Dumy";
        $user3->username = "dumy.it";
        $user3->password = Hash::make('!ntouch247');
        $user3->email = "dumy.it@24-7intouch.com";
        $user3->ContactInfo = "+573000002";
        $user3->status = "Active";
        $user3->privilege = 20001;
        $user3->save();

        $user4 = new User();
        $user4->cde = "C220809";
        $user4->name = "Sebastian Camilo Gonzalez Sanchez";
        $user4->position = "Agent";
        $user4->username = "sebastian.gonzalez";
        $user4->password = Hash::make('!ntouch247@');
        $user4->email = "sebastian.gonzalez@24-7intouch.com";
        $user4->ContactInfo = "3507616668";
        $user4->status = "Active";
        $user4->privilege = 40001;
        $user4->save();
        
        $user5 = new User();
        $user5->cde = "C221328";
        $user5->name = "Valeria Barberi Ochoa";
        $user5->position = "Agent";
        $user5->username = "valeria.barberi";
        $user5->password = Hash::make('!ntouch247@');
        $user5->email = "valeria.barberi@24-7intouch.com";
        $user5->ContactInfo = "3204914511";
        $user5->status = "Active";
        $user5->privilege = 40001;
        $user5->save();

        $user6 = new User();
        $user6->cde = "C221332";
        $user6->name = "Natalia Patricia Gonzalez Maldonado";
        $user6->position = "Agent";
        $user6->username = "natalia.gonzalez";
        $user6->password = Hash::make('!ntouch247@');
        $user6->email = "natalia.gonzalez@24-7intouch.com";
        $user6->ContactInfo = "3156932797";
        $user6->status = "Active";
        $user6->privilege = 40001;
        $user6->save();

        $user7 = new User();
        $user7->cde = "C220395";
        $user7->name = "Santiago Chicaeme";
        $user7->position = "IT Intern";
        $user7->username = "santiago.chicaeme";
        $user7->password = Hash::make('!ntouch247');
        $user7->email = "santiago.chicaeme@24-7intouch.com";
        $user7->ContactInfo = "+573104848348";
        $user7->status = "Active";
        $user7->privilege = 30001;
        $user7->save();

        $user8 = new User();
        $user8->cde = "C211914";
        $user8->name = "Camilo Castellanos";
        $user8->position = "IT Generalist";
        $user8->username = "camilo.castellanos";
        $user8->password = Hash::make('BICI123.');
        $user8->email = "camilo.castellanos@24-7intouch.com";
        $user8->ContactInfo = "+573214867264";
        $user8->status = "Active";
        $user8->privilege = 30001;
        $user8->save();

        $user9 = new User();
        $user9->cde = "C19008";
        $user9->name = "Ivan Hernandez";
        $user9->position = "IT Generalist";
        $user9->username = "ivan.hernandez";
        $user9->password = Hash::make('!ntouch247');
        $user9->email = "ivan.hernandez@24-7intouch.com";
        $user9->ContactInfo = "+573143517586";
        $user9->status = "Active";
        $user9->privilege = 10001;
        $user9->save();

        $user10 = new User();
        $user10->cde = "C220076";
        $user10->name = "Lizeth Martinez";
        $user10->position = "IT Intern";
        $user10->username = "lizeth.martinez";
        $user10->password = Hash::make('!ntouch247');
        $user10->email = "lizeth.martinez@24-7intouch.com";
        $user10->ContactInfo = "+573213101709";
        $user10->status = "Active";
        $user10->privilege = 30001;
        $user10->save();

        $user11 = new User();
        $user11->cde = "C220113";
        $user11->name = "Jeimy Pineda";
        $user11->position = "IT Intern";
        $user11->username = "jeimy.pineda";
        $user11->password = Hash::make('!ntouch247');
        $user11->email = "jeimy.pineda@24-7intouch.com";
        $user11->ContactInfo = "+573196167256";
        $user11->status = "Active";
        $user11->privilege = 30001;
        $user11->save();

        $user12 = new User();
        $user12->cde = "C210000";
        $user12->name = "Camila Rubio";
        $user12->position = "IT Generalist";
        $user12->username = "maria.rubio01";
        $user12->password = Hash::make('LEYVA400.');
        $user12->email = "maria.rubio01@24-7intouch.com";
        $user12->ContactInfo = "+573115476038";
        $user12->status = "Active";
        $user12->privilege = 30001;
        $user12->save();


    }
}
