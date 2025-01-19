<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image' => 'https://picsum.photos/seed/picsum/400/400',
            'sku' => $this->faker->isbn10(),
            'category_id' => 1,
        ];
    }
}
