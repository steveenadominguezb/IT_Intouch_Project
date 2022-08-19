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

        $user13 = new User();
        $user13->cde = "C22185";
        $user13->name = "Cristian David Cordoba Suarez";
        $user13->position = "IT Generalist";
        $user13->username = "cristian.suarez";
        $user13->password = Hash::make('!ntouch247');
        $user13->email = "cristian.suarez@24-7intouch.com";
        $user13->ContactInfo = "+573001234567";
        $user13->status = "Active";
        $user13->privilege = 30001;
        $user13->save();

        $user14 = new User();
        $user14->cde = "C222238";
        $user14->name = "Laura Virginia Pena Cabrera";
        $user14->position = "IT Intern";
        $user14->username = "lauravirginia.pena";
        $user14->password = Hash::make('!ntouch247');
        $user14->email = "laura.pena@24-7intouch.com";
        $user14->ContactInfo = "+573001234567";
        $user14->status = "Active";
        $user14->privilege = 30001;
        $user14->save();

        $user15 = new User();
        $user15->cde = "C222450";
        $user15->name = "Angela Tatiana Garzon Martinez";
        $user15->position = "IT Intern";
        $user15->username = "angela.garzon";
        $user15->password = Hash::make('!ntouch247');
        $user15->email = "angela.garzon@24-7intouch.com";
        $user15->ContactInfo = "+573001234567";
        $user15->status = "Active";
        $user15->privilege = 30001;
        $user15->save();

        $user16 = new User();
        $user16->cde = "C222426";
        $user16->name = "Jose Lisandro Mora Fiesco";
        $user16->position = "IT Intern";
        $user16->username = "jose.mora";
        $user16->password = Hash::make('!ntouch247');
        $user16->email = "jose.mora@24-7intouch.com";
        $user16->ContactInfo = "+573001234567";
        $user16->status = "Active";
        $user16->privilege = 30001;
        $user16->save();

        $user17 = new User();
        $user17->cde = "C212990";
        $user17->name = "Laura Alejandra Acero Amaya";
        $user17->position = "HR Intern";
        $user17->username = "laura.amaya";
        $user17->password = Hash::make('Bogota2022*');
        $user17->email = "laura.amaya@24-7intouch.com";
        $user17->ContactInfo = "3229455501";
        $user17->status = "Active";
        $user17->privilege = 50001;
        $user17->save();
    }
}
