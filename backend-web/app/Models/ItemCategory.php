<?php

namespace App\Models;

use App\Data\ItemCategoryData;
use Database\Factories\ItemCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class ItemCategory extends Model
{
    /** @use HasFactory<ItemCategoryFactory> */
    use HasFactory;

    public $timestamps = false;

    public function translations(): HasMany
    {
        return $this->hasMany(ItemCategoryTranslation::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function receiptItems(): HasMany
    {
        return $this->hasMany(ReceiptItem::class, 'category_id');
    }

    public function toData(): ItemCategoryData
    {
        return ItemCategoryData::from($this);
    }
}
