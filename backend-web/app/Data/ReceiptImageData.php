<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class ReceiptImageData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $receipt_id,
        public readonly string $url,
        public readonly int $order,
        public readonly ?CarbonImmutable $created_at,
    ) {}
}
