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
        $user1->position = "IT Generalist";
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

    }
}
