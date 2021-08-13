<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function($user) {
            $categories = Category::all();
            $brands = Brand::all();

            for ($i=0; $i < 10; $i++) {
                Product::factory(10)->create([
                    'user_id' => $user->id,
                    'category_id' => $categories->random()->id,
                    'brand_id' => $brands->random()->id
                ]);
            }
        });
    }
}
