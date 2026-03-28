<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class ReceiptData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $account_id,
        public readonly ?int $category_id,
        public readonly ?int $scanned_by,
        public readonly string $receipt_number,
        public readonly CarbonImmutable $date,
        public readonly ?CarbonImmutable $scan_time,
        public readonly ?string $place,
        public readonly ?string $shop,
        public readonly ?string $bank,
        public readonly string $change,
        public readonly string $total,
        public readonly ?string $payment_type,
        public readonly string $tax_amount,
        public readonly string $tax_pct,
        public readonly ?string $description,
        public readonly bool $is_enhanced_scan,
        public readonly ?CarbonImmutable $created_at,
    ) {}
}
