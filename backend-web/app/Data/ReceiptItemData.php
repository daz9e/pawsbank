<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class ReceiptItemData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $receipt_id,
        public readonly ?int $product_id,
        public readonly ?int $category_id,
        public readonly string $name,
        public readonly string $price,
        public readonly string $amount,
        public readonly ?string $unit,
        public readonly string $total_price,
        public readonly ?CarbonImmutable $created_at,
    ) {}
}
