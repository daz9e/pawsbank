<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly ?int $category_id,
        public readonly string $name,
    ) {}
}
