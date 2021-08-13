<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::all()->each(function($address) {
            Order::factory(rand(10, 100))->create([
                'user_id' => $address->user->id,
                'address_id' => $address->id
            ]);
        });
    }
}
