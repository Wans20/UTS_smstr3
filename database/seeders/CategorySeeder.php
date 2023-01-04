<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $category = ["accesories","components","software","electronics"];
        foreach( $category as $key => $categories){
            category::create([
                "name" => $categories,
                "status" => $faker->randomElement(['Active', 'Inactive']),
                "description" => $faker->paragraph()
            ]);
        }
    }
}
