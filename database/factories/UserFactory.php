<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $privateName = $this->faker->firstName;
        $commonPassword = bcrypt('12345678');

        return [
            'public_name' => $this->faker->userName,
            'private_name' => $privateName,
            'pin_code' => $this->faker->randomNumber(6),
            'password' => $commonPassword,
            'store_key' => Str::random(64),
            'login_passphrase' => Str::random(5),
            'role' => $this->faker->randomElement(['user', 'store', 'admin']),
            'status' => $this->faker->randomElement(['active']),
            'store_status' => $this->faker->randomElement(['active', 'in_active', 'pending', 'suspended', 'banned']),
            'theme' => $this->faker->randomElement(['white', 'dark']),
            'last_seen' => now(),
        ];
    }
}
