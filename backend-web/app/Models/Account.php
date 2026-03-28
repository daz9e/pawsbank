<?php

namespace App\Models;

use App\Data\AccountData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'currency_code'])]
class Account extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'account_users')
            ->withPivot(['role', 'invited_by', 'joined_at']);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function toData(): AccountData
    {
        return AccountData::from($this);
    }
}
