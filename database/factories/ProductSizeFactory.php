<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->randomElement(['1kg', '500g', '250g']),
            'price' => $this->faker->numberBetween(4000, 15000),
            'modal' => $this->faker->numberBetween(2000, 10000),
            'stock' => $this->faker->numberBetween(2, 10),
            'slug' => $this->faker->unique()->slug,
            'product_id' => $this->faker->numberBetween(1, 10),

        ];
    }
}
