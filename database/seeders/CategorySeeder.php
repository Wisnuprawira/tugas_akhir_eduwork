<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i=0;$i<5;$i++){
                $category = new Category;

                $category->ct_code = rand(1,5);
                $category->ct_name = $faker->name;
                $category->ct_price = 'Rp'.rand(10000, 20000);

                // Simpan category ke database
                $category->save();
            }
        }
    }

