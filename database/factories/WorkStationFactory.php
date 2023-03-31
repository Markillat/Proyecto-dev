<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class WorkStationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
            'description' => fake()->text,
            'salary' => fake()->numberBetween(1000, 10000),
            'publication_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
        ];
    }
}
