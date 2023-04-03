<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $curriculum_vitae = UploadedFile::fake()->create('cv.pdf');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'workstation_id' => Workstation::inRandomOrder()->first()->id,
            'message' => fake()->paragraph(),
            'curriculum_vitae' => $curriculum_vitae,
            'status_job' => fake()->randomElement(['pendiente', 'enviado', 'rechazado', 'finalista']),
        ];
    }
}
