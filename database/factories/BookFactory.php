<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publish_date' => fake()->date(),
            'type' => fake()->word(),
            'description' => fake()->paragraph(),
            'editor' => fake()->word(),
            'language' => fake()->word(),
            'copys' => fake()->numberBetween(1, 10),
        ];
    }
}
