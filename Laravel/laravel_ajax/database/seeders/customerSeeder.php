<?php

namespace Database\Seeders;

use App\Models\customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use Faker\Factory as faker;

class customerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Faker::create();
        for ($i = 1; $i <= 100; $i++) {
            $data = new customer();
            $data->name = $faker->name; // $faker->sentence(3)
            $data->email = $faker->email;
            $data->password = $faker->password;
            $data->save();
        }

    }
}
