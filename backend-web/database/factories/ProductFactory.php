<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => ItemCategory::factory(),
            'name' => fake()->words(fake()->numberBetween(1, 3), true),
        ];
    }

    public function withoutCategory(): static
    {
        return $this->state(['category_id' => null]);
    }
}
