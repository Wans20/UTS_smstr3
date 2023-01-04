<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $title = ["Mouse Logitech","Headset Razer","Headset Sades","Mouse Razer","keyboard mechanical logitech"];
        foreach($title as $key => $titles){
            Product::create([
                 "title" => $titles,
                 "description" => $faker->paragraph(),
                 "status" => $faker->randomElement(["active","inactive","draft"]),
                 "price" => 500000,
                 "weight" => 3.2,
                 "category_id" => $faker->randomElement([1,2,3,4,5])
            ]);
        }
    }
}
