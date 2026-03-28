<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccountUser>
 */
class AccountUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'user_id' => User::factory(),
            'role' => fake()->randomElement(['owner', 'admin', 'member']),
            'invited_by' => null,
            'joined_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
