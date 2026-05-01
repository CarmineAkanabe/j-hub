<?php

namespace Database\Factories;

use App\Models\Application;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => ApplicationStatus::PENDING->value,
            'date'   => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
