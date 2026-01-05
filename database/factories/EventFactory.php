<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'start_time' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'capacity' => fake()->numberBetween(10, 100),
        ];
    }
}
