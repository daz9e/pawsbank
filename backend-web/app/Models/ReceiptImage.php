<?php

namespace App\Models;

use App\Data\ReceiptImageData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['receipt_id', 'url', 'order'])]
class ReceiptImage extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function toData(): ReceiptImageData
    {
        return ReceiptImageData::from($this);
    }
}
