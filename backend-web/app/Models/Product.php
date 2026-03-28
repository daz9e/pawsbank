<?php

namespace App\Models;

use App\Data\ProductData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'name'])]
class Product extends Model
{
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function receiptItems(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function toData(): ProductData
    {
        return ProductData::from($this);
    }
}
