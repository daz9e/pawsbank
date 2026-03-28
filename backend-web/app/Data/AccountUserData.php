<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class AccountUserData extends Data
{
    public function __construct(
        public readonly int $account_id,
        public readonly int $user_id,
        public readonly string $role,
        public readonly ?int $invited_by,
        public readonly ?CarbonImmutable $joined_at,
    ) {}
}
