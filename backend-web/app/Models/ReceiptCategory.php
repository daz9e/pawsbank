<?php

namespace App\Models;

use App\Data\ReceiptCategoryData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class ReceiptCategory extends Model
{
    public $timestamps = false;

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'category_id');
    }

    public function toData(): ReceiptCategoryData
    {
        return ReceiptCategoryData::from($this);
    }
}
