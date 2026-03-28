<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class AccountData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $currency_code,
        public readonly ?CarbonImmutable $created_at,
    ) {}
}
