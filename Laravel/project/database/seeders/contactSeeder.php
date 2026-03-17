<?php

namespace Database\Seeders;

use App\Models\contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

Use Faker\Factory as faker;

class contactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
       // seeding
        $table=new contact();
        $table->name="Rahul";
        $table->email="Rahul2@gmail.com";
        $table->comment="Helllo address plz";
        $table->save();    

        // cmd =>  php artisan db:seed
        */


        // faker
        $faker=Faker::create();
        for($i=1;$i<=100;$i++)
        {
            $table=new contact();
            $table->name=$faker->name;
            $table->email=$faker->email;
            $table->comment=$faker->realText;
            $table->save();    
        }
    }
}
