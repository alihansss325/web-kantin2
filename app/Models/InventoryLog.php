<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'action',
        'previous_stock',
        'quantity_change',
        'new_stock',
        'reason',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'previous_stock' => 'integer',
        'quantity_change' => 'integer',
        'new_stock' => 'integer',
        'reference_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeIn($query)
    {
        return $query->where('action', 'in');
    }

    public function scopeOut($query)
    {
        return $query->where('action', 'out');
    }

    public function scopeAdjustment($query)
    {
        return $query->where('action', 'adjustment');
    }

    public function scopeSale($query)
    {
        return $query->where('action', 'sale');
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'in' => 'Masuk',
            'out' => 'Keluar',
            'adjustment' => 'Penyesuaian',
            'sale' => 'Penjualan',
            default => ucfirst($this->action),
        };
    }

    public function getFormattedQuantityChangeAttribute(): string
    {
        $sign = $this->quantity_change >= 0 ? '+' : '';
        return $sign . $this->quantity_change;
    }

    public function isStockIn(): bool
    {
        return $this->action === 'in';
    }

    public function isStockOut(): bool
    {
        return in_array($this->action, ['out', 'sale']);
    }

    public function isAdjustment(): bool
    {
        return $this->action === 'adjustment';
    }
}
