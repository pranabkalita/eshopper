<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(3),
            'tags' => 'Cloths,Shoes,Electronics',
            'price' => rand(10000, 100000),
            'isPublished' => $this->faker->boolean(),
            'isPromoted' => $this->faker->boolean(),
        ];
    }
}
