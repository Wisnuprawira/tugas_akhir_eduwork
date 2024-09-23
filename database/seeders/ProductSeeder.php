<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Faker\Factory as faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil 5 orders dan 5 categories secara acak
        $categories = Category::inRandomOrder()->take(5)->get();

        if ($categories->isNotEmpty()) {
          foreach ($categories as $category) {
            for($i=0;$i<5;$i++){

            $product = new Product;

            $product->pd_code =rand(1,10);
            $product->pd_ct_id=$category->ct_id;
            $product->pd_name=$faker->name;
            $product->pd_price='Rp'.rand(10000,20000);


            $product->save();


                }
            }
        }
    }
}
