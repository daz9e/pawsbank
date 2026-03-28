<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ItemCategoryTranslationData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $item_category_id,
        public readonly string $locale,
        public readonly string $name,
    ) {}
}
