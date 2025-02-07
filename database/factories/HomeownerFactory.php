<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Homeowner>
 */
class HomeownerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['Mr', 'Mister', 'Mrs', 'Ms', 'Dr', 'Prof']),
            'first_name' => fake()->optional()->firstName(),
            'initial' => optional(fake()->optional()->randomLetter(), fn($initial) => strtoupper($initial)),
            'last_name' => fake()->lastName(),
        ];
    }
}
