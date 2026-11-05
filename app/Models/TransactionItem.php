<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'final_amount',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedProductPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedFinalAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->final_amount, 0, ',', '.');
    }

    public function getTotalProfitAttribute(): float
    {
        if ($this->product && $this->product->cost_price) {
            return ($this->product_price - $this->product->cost_price) * $this->quantity;
        }
        return 0;
    }

    public function getFormattedTotalProfitAttribute(): string
    {
        return 'Rp ' . number_format($this->total_profit, 0, ',', '.');
    }
}
