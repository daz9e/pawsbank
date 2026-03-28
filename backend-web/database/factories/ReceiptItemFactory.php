<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReceiptItem>
 */
class ReceiptItemFactory extends Factory
{
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 1, 200);
        $amount = fake()->randomFloat(3, 0.1, 10);

        return [
            'receipt_id' => Receipt::factory(),
            'product_id' => null,
            'category_id' => null,
            'name' => fake()->words(fake()->numberBetween(1, 3), true),
            'price' => $price,
            'amount' => $amount,
            'unit' => fake()->randomElement(['pcs', 'kg', 'l', 'g', null]),
            'total_price' => round($price * $amount, 2),
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }

    public function withProduct(): static
    {
        return $this->state([
            'product_id' => Product::factory(),
            'category_id' => ItemCategory::factory(),
        ]);
    }
}
