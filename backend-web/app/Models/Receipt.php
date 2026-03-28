<?php

namespace App\Models;

use App\Data\ReceiptData;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'account_id',
    'category_id',
    'scanned_by',
    'receipt_number',
    'date',
    'scan_time',
    'place',
    'shop',
    'bank',
    'change',
    'total',
    'payment_type',
    'tax_amount',
    'tax_pct',
    'description',
    'is_enhanced_scan',
])]
class Receipt extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'scan_time' => 'datetime',
            'created_at' => 'datetime',
            'change' => 'decimal:2',
            'total' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'tax_pct' => 'decimal:2',
            'is_enhanced_scan' => 'boolean',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReceiptCategory::class, 'category_id');
    }

    public function scannedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReceiptImage::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function toData(): ReceiptData
    {
        return ReceiptData::from($this);
    }
}
