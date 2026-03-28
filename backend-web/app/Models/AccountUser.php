<?php

namespace App\Models;

use App\Data\AccountUserData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['account_id', 'user_id', 'role', 'invited_by', 'joined_at'])]
class AccountUser extends Pivot
{
    public $timestamps = false;

    protected $table = 'account_users';

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function toData(): AccountUserData
    {
        return AccountUserData::from($this);
    }
}
