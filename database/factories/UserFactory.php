<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'     => fake()->name(),
            'email'    => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'role'     => UserRole::JOBSEEKER->value,
        ];
    }

    public function employer(): static
    {
        return $this->state(['role' => UserRole::EMPLOYER->value, 'company_name' => fake()->company()]);
    }

    public function admin(): static
    {
        return $this->state(['role' => UserRole::ADMIN->value]);
    }

    public function jobSeeker(): static
    {
        return $this->state(['role' => UserRole::JOBSEEKER->value, 'resume' => fake()->paragraph()]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
