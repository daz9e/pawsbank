<?php

namespace App\Models;

use App\Data\ReceiptItemData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'receipt_id',
    'product_id',
    'category_id',
    'name',
    'price',
    'amount',
    'unit',
    'total_price',
])]
class ReceiptItem extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'price' => 'decimal:2',
            'amount' => 'decimal:3',
            'total_price' => 'decimal:2',
        ];
    }

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function toData(): ReceiptItemData
    {
        return ReceiptItemData::from($this);
    }
}
