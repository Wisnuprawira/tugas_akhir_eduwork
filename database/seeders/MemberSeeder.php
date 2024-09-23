<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\Order;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        for($i=0;$i<10;$i++){
            $member = new Member;

            $member->ms_name=$faker->name;
            $member->ms_email=$faker->email;
            $member->ms_password=$faker->password;
            $member->ms_phone_number='0821'.$faker->randomNumber(8);
            $member->ms_address=$faker->address;

            $member->save();

        }
    }
}
