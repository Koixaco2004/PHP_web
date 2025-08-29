<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'user', 'subscriber']),
            'google_id' => null,
            'avatar' => fake()->optional(0.3)->imageUrl(200, 200, 'people'),
            'bio' => fake()->optional(0.5)->paragraph(),
            'location' => fake()->optional(0.4)->city(),
            'website' => fake()->optional(0.2)->url(),
            'phone' => fake()->optional(0.3)->phoneNumber(),
            'date_of_birth' => fake()->optional(0.6)->dateTimeBetween('-60 years', '-18 years')?->format('Y-m-d'),
            'profile_views' => fake()->numberBetween(0, 1000),
            'is_private' => fake()->boolean(20), // 20% chance of being private
            'remember_token' => Str::random(10),
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
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the user should be a regular user.
     */
    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'user',
        ]);
    }

    /**
     * Indicate that the user should be a subscriber.
     */
    public function subscriber(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'subscriber',
            'password' => null, // Subscribers may not have passwords
        ]);
    }

    /**
     * Indicate that the user has Google login.
     */
    public function withGoogle(): static
    {
        return $this->state(fn (array $attributes) => [
            'google_id' => fake()->uuid(),
            'avatar' => fake()->imageUrl(200, 200, 'people'),
        ]);
    }
}
