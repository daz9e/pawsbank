<?php

namespace App\Models;

use App\Data\ItemCategoryTranslationData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['item_category_id', 'locale', 'name'])]
class ItemCategoryTranslation extends Model
{
    public $timestamps = false;

    public function itemCategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function toData(): ItemCategoryTranslationData
    {
        return ItemCategoryTranslationData::from($this);
    }
}
