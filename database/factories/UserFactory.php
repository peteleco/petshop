<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'is_admin' => false,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('userpassword'),
            'avatar' => null,
            'address' => fake()->realText(255),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => false,
            'last_login_at' => null,
        ];
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

    /**
     * Indicate that the user is an Admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
            'password' => Hash::make('admin')
        ]);
    }

    /**
     * Indicate that the user signed for campaign mkt.
     */
    public function marketing(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_marketing' => true,
        ]);
    }
}
