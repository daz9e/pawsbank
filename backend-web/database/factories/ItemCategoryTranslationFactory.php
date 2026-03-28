<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use App\Models\ItemCategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemCategoryTranslation>
 */
class ItemCategoryTranslationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_category_id' => ItemCategory::factory(),
            'locale' => fake()->randomElement(['en', 'ru', 'de', 'fr', 'es']),
            'name' => fake()->word(),
        ];
    }
}
