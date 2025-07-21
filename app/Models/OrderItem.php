<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id_order_items';

    protected $fillable = [
        'id_order',
        'id_product',
        'total',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'integer',
    ];

    /**
     * Boot method untuk auto-update order total saat item berubah
     */
    protected static function boot()
    {
        parent::boot();

        // Update order total setelah item dibuat
        static::created(function ($orderItem) {
            $orderItem->updateOrderTotal();
        });

        // Update order total setelah item diupdate
        static::updated(function ($orderItem) {
            $orderItem->updateOrderTotal();
        });

        // Update order total setelah item dihapus
        static::deleted(function ($orderItem) {
            $orderItem->updateOrderTotal();
        });
    }

    /**
     * Relasi ke Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    /**
     * Relasi ke Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    /**
     * Relasi ke Review
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class, 'order_item_id', 'id_order_items');
    }

    /**
     * Update total harga order berdasarkan semua order items
     */
    public function updateOrderTotal(): void
    {
        if ($this->order) {
            $totalHarga = static::where('id_order', $this->id_order)->sum('subtotal');
            $this->order->update(['total_harga' => $totalHarga]);
        }
    }

    /**
     * Accessor untuk mendapatkan nama produk
     */
    public function getProductNameAttribute(): string
    {
        return $this->product?->product_name ?? 'Unknown Product';
    }

    /**
     * Accessor untuk mendapatkan nama customer
     */
    public function getCustomerNameAttribute(): string
    {
        return $this->order?->customer?->nama_lengkap ?? 'Unknown Customer';
    }

    /**
     * Accessor untuk mendapatkan order number
     */
    public function getOrderNumberAttribute(): string
    {
        return $this->order?->order_number ?? 'Unknown Order';
    }

    /**
     * Accessor untuk mendapatkan format subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Accessor untuk mendapatkan format unit price
     */
    public function getFormattedUnitPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->unit_price, 0, ',', '.');
    }

    /**
     * Check apakah item ini sudah direview
     */
    public function hasReview(): bool
    {
        return $this->review()->exists();
    }

    /**
     * Get rating jika ada review
     */
    public function getRatingAttribute(): ?int
    {
        return $this->review?->rating;
    }

    /**
     * Scope untuk filter berdasarkan order status
     */
    public function scopeByOrderStatus($query, string $status)
    {
        return $query->whereHas('order', function ($q) use ($status) {
            $q->where('status_order', $status);
        });
    }

    /**
     * Scope untuk filter berdasarkan customer
     */
    public function scopeByCustomer($query, int $customerId)
    {
        return $query->whereHas('order', function ($q) use ($customerId) {
            $q->where('customer_id', $customerId);
        });
    }

    /**
     * Scope untuk filter berdasarkan produk
     */
    public function scopeByProduct($query, int $productId)
    {
        return $query->where('id_product', $productId);
    }

    /**
     * Scope untuk filter berdasarkan range subtotal
     */
    public function scopeBySubtotalRange($query, float $min = null, float $max = null)
    {
        if ($min !== null) {
            $query->where('subtotal', '>=', $min);
        }
        
        if ($max !== null) {
            $query->where('subtotal', '<=', $max);
        }
        
        return $query;
    }

    /**
     * Scope untuk item dengan review
     */
    public function scopeWithReview($query)
    {
        return $query->whereHas('review');
    }

    /**
     * Scope untuk item tanpa review
     */
    public function scopeWithoutReview($query)
    {
        return $query->whereDoesntHave('review');
    }

    /**
     * Scope untuk high value items
     */
    public function scopeHighValue($query, float $threshold = 1000000)
    {
        return $query->where('subtotal', '>', $threshold);
    }

    /**
     * Get total revenue dari semua order items
     */
    public static function getTotalRevenue(): float
    {
        return static::sum('subtotal');
    }

    /**
     * Get average order item value
     */
    public static function getAverageItemValue(): float
    {
        return static::avg('subtotal') ?? 0;
    }

    /**
     * Get most ordered product
     */
    public static function getMostOrderedProduct(): ?Product
    {
        $productId = static::selectRaw('id_product, SUM(total) as total_ordered')
            ->groupBy('id_product')
            ->orderByDesc('total_ordered')
            ->first()?->id_product;

        return $productId ? Product::find($productId) : null;
    }

    /**
     * Get best customer by total purchase
     */
    public static function getBestCustomer(): ?Customer
    {
        $customerId = static::join('orders', 'order_items.id_order', '=', 'orders.id_order')
            ->selectRaw('orders.customer_id, SUM(order_items.subtotal) as total_purchase')
            ->groupBy('orders.customer_id')
            ->orderByDesc('total_purchase')
            ->first()?->customer_id;

        return $customerId ? Customer::find($customerId) : null;
    }
}