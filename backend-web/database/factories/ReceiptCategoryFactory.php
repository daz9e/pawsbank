<?php

namespace Database\Factories;

use App\Models\ReceiptCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReceiptCategory>
 */
class ReceiptCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Groceries', 'Restaurants', 'Transport', 'Healthcare',
                'Electronics', 'Clothing', 'Entertainment', 'Utilities',
            ]),
        ];
    }
}
