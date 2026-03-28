<?php

namespace Database\Factories;

use App\Models\Receipt;
use App\Models\ReceiptImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReceiptImage>
 */
class ReceiptImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'receipt_id' => Receipt::factory(),
            'url' => fake()->imageUrl(640, 480, 'receipts'),
            'order' => 0,
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
