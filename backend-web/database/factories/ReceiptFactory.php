<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Receipt>
 */
class ReceiptFactory extends Factory
{
    public function definition(): array
    {
        $total = fake()->randomFloat(2, 5, 500);
        $taxPct = fake()->randomElement([0, 5, 10, 20]);
        $taxAmount = round($total * $taxPct / 100, 2);

        return [
            'account_id' => Account::factory(),
            'category_id' => ReceiptCategory::factory(),
            'scanned_by' => User::factory(),
            'receipt_number' => fake()->numerify('REC-######'),
            'date' => fake()->dateTimeBetween('-1 year'),
            'scan_time' => fake()->dateTimeBetween('-1 year'),
            'place' => fake()->city(),
            'shop' => fake()->company(),
            'bank' => fake()->randomElement(['Sberbank', 'Tinkoff', 'Alfa', 'VTB', null]),
            'change' => fake()->randomFloat(2, 0, 50),
            'total' => $total,
            'payment_type' => fake()->randomElement(['cash', 'card', 'nfc']),
            'tax_amount' => $taxAmount,
            'tax_pct' => $taxPct,
            'description' => fake()->optional()->sentence(),
            'is_enhanced_scan' => fake()->boolean(20),
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }

    public function withoutCategory(): static
    {
        return $this->state(['category_id' => null]);
    }

    public function enhancedScan(): static
    {
        return $this->state(['is_enhanced_scan' => true]);
    }
}
