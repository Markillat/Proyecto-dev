<?php

namespace Database\Factories;

use App\Models\User;
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
            'phone' => fake()->phoneNumber,
            'curriculum_vitae' => $curriculum_vitae,
            'send_status' => fake()->randomElement(['pending', 'sent', 'rejected']),
        ];
    }
}
