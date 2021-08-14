<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::all()->each(function($order) {
            OrderStatus::factory(1)->create([
                'order_id' => $order->id
            ]);
        });
    }
}
