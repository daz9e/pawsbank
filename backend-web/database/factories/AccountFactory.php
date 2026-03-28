<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'currency_code' => fake()->randomElement(['USD', 'EUR', 'RUB', 'GBP']),
            'created_at' => fake()->dateTimeBetween('-2 years'),
        ];
    }
}
