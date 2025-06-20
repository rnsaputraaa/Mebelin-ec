<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'order_number',
        'customer_id',
        'total_harga',
        'status_order',
        'catatan',
        'tanggal_order',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_order' => 'date',
        'expired_at' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Boot method untuk auto-generate order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $orderNumber = $prefix . $date . $random;
        
        // Ensure uniqueness
        while (static::where('order_number', $orderNumber)->exists()) {
            $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = $prefix . $date . $random;
        }
        
        return $orderNumber;
    }

    /**
     * Relasi ke Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id_customer');
    }

    /**
     * Relasi ke OrderItems
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->orderItems()->sum('total');
    }

    /**
     * Get total unique products count
     */
    public function getTotalProductsAttribute(): int
    {
        return $this->orderItems()->count();
    }

    /**
     * Accessor untuk status order dengan format yang lebih baik
     */
    public function getFormattedStatusAttribute(): string
    {
        return match ($this->status_order) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status_order)
        };
    }

    /**
     * Accessor untuk total harga dengan format rupiah
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Check apakah order sudah expired
     */
    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    /**
     * Check apakah order bisa dibatalkan
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status_order, ['pending', 'processing']);
    }

    /**
     * Check apakah order sudah selesai
     */
    public function isCompleted(): bool
    {
        return $this->status_order === 'delivered';
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status_order', $status);
    }

    /**
     * Scope untuk filter berdasarkan customer
     */
    public function scopeByCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope untuk order yang aktif (tidak cancelled)
     */
    public function scopeActive($query)
    {
        return $query->where('status_order', '!=', 'cancelled');
    }

    /**
     * Scope untuk order yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status_order', 'pending');
    }

    /**
     * Scope untuk order yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status_order', 'delivered');
    }

    /**
     * Scope untuk order hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_order', today());
    }

    /**
     * Scope untuk order minggu ini
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('tanggal_order', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope untuk order bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_order', now()->month)
                    ->whereYear('tanggal_order', now()->year);
    }

    /**
     * Update status order
     */
    public function updateStatus(string $status, string $note = null): bool
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $this->update([
            'status_order' => $status,
            'catatan' => $note ? $this->catatan . "\n" . $note : $this->catatan,
        ]);

        return true;
    }

    /**
     * Recalculate total harga berdasarkan order items
     */
    public function recalculateTotal(): void
    {
        $total = $this->orderItems()->sum('subtotal');
        $this->update(['total_harga' => $total]);
    }

    /**
     * Get revenue per hari
     */
    public static function getDailyRevenue(\DateTime $date = null): float
    {
        $date = $date ?: today();
        
        return static::whereDate('tanggal_order', $date)
                    ->where('status_order', '!=', 'cancelled')
                    ->sum('total_harga');
    }

    /**
     * Get revenue per bulan
     */
    public static function getMonthlyRevenue(int $month = null, int $year = null): float
    {
        $month = $month ?: now()->month;
        $year = $year ?: now()->year;
        
        return static::whereMonth('tanggal_order', $month)
                    ->whereYear('tanggal_order', $year)
                    ->where('status_order', '!=', 'cancelled')
                    ->sum('total_harga');
    }

    /**
     * Get order statistics
     */
    public static function getStatistics(): array
    {
        return [
            'total_orders' => static::count(),
            'pending_orders' => static::where('status_order', 'pending')->count(),
            'completed_orders' => static::where('status_order', 'delivered')->count(),
            'cancelled_orders' => static::where('status_order', 'cancelled')->count(),
            'total_revenue' => static::where('status_order', '!=', 'cancelled')->sum('total_harga'),
            'average_order_value' => static::where('status_order', '!=', 'cancelled')->avg('total_harga'),
            'today_orders' => static::whereDate('tanggal_order', today())->count(),
            'today_revenue' => static::getDailyRevenue(),
        ];
    }
}