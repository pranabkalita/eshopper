<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function($product) {
            Review::factory(rand(10,20))->create([
                'product_id' => $product->id,
                'user_id' => User::all()->random()->id,
            ]);
        });
    }
}
