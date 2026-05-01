<?php

namespace Database\Factories;

use App\Models\Job;
use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'           => fake()->jobTitle(),
            'description'     => fake()->paragraphs(3, true),
            'location'        => fake()->city(),
            'expected_salary' => fake()->randomFloat(2, 100000, 2000000),
            'status'          => JobStatus::OPEN->value,
        ];
    }
}
