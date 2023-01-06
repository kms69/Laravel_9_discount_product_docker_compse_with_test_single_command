<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'category' =>fake()-> randomElement(['boots','sneakers']),
            'price' => fake()->numberBetween($min = 1500, $max = 6000),
            'sku' => fake()-> randomElement(['00001','00003','00004']),
        ];
    }
}
