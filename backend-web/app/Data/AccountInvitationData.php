<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class AccountInvitationData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $account_id,
        public readonly int $invited_by,
        public readonly int $user_id,
        public readonly string $status,
        public readonly CarbonImmutable $expires_at,
        public readonly ?CarbonImmutable $created_at,
    ) {}
}
