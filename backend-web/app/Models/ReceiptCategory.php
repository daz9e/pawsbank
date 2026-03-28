<?php

namespace App\Models;

use App\Data\ReceiptCategoryData;
use Database\Factories\ReceiptCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class ReceiptCategory extends Model
{
    /** @use HasFactory<ReceiptCategoryFactory> */
    use HasFactory;

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
