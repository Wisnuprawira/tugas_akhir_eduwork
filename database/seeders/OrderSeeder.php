<?php

namespace Database\Seeders;
use Faker\Factory as faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $products = Product::inRandomOrder()->take(5)->get();


        for($i=0;$i<20;$i++){
            $product = $products->random();
            $order = new Order;

            $order->or_pd_id=$product->pd_id;
            $order->or_amount=$faker->randomNumber(2);
            $order->save();
        }
    }
}
