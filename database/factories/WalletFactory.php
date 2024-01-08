<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        // Shuffle the user IDs to avoid repetition
        shuffle($userIds);

        $userId = array_pop($userIds);

        return [
            'user_id' => $userId,
            'seed' => $this->faker->text,
            'balance' => $this->faker->numberBetween(500, 1000),
            'private_key' => $this->faker->uuid,
            'public_key' => $this->faker->uuid,
            'status' => $this->faker->randomElement(['active']),
        ];
    }
}
