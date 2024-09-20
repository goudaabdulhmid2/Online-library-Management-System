<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title' =>fake()->sentence(),
           'author' => fake()->name(),
           'genre_id' => fake()->numberBetween(1, 10),
           'description' => fake()->paragraph(),
           'quantity'=>fake()->numberBetween(1,50)
        ];
    }
}
