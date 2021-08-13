<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::all()->each(function($order) {
            // Have to do this way to get new product id for every order detail
            $products = Product::isLive()->get();
            for ($i=0; $i < 10; $i++) {
                OrderDetail::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $products->random()->id
                ]);
            }
        });
    }
}
