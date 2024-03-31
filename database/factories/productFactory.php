<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'brand_name' => fake()->word(),
            'price' => fake()->randomNumber(),
            'quantity' => fake()->randomNumber(),
            'category_id' => 1,
            'user_id' => 1,
            "images_url"=>'["photo1.png"]',
            "specs"=>'["album:true"]'
        ];
    }
}
