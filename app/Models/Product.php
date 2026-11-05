<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'cost_price',
        'stock',
        'min_stock',
        'unit',
        'image',
        'barcode',
        'status',
        'is_featured',
        'is_taxable',
        'tax_percentage',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_taxable' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock <= min_stock');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedCostPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->cost_price, 0, ',', '.');
    }

    public function getProfitAttribute(): float
    {
        return $this->price - $this->cost_price;
    }

    public function getProfitPercentageAttribute(): float
    {
        if ($this->cost_price == 0) return 0;
        return ($this->profit / $this->cost_price) * 100;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    public function getTaxAmountAttribute(): float
    {
        if (!$this->is_taxable) return 0;
        return ($this->price * $this->tax_percentage) / 100;
    }

    public function getPriceWithTaxAttribute(): float
    {
        return $this->price + $this->tax_amount;
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/default-product.jpg');
        }
        return asset('storage/' . $this->image);
    }

    public function canBeSold(): bool
    {
        return $this->status === 'available' && $this->stock > 0;
    }

    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}
