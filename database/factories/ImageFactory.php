<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' => collect([
                asset('/images/products/dummy/1.jpg'),
                asset('/images/products/dummy/2.jpg'),
                asset('/images/products/dummy/3.jpg'),
                asset('/images/products/dummy/4.jpg'),
            ])->random()
        ];
    }
}
