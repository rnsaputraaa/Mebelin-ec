<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStock extends Model
{
    use HasFactory;

    protected $table = 'report_stock';
    protected $primaryKey = 'id_report_stock';

    protected $fillable = [
        'id_product',
        'type',
        'quantity',
        'movement_date',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'quantity' => 'integer',
    ];

    /**
     * Boot method untuk auto-update stok produk
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($report) {
            $report->updateProductStock();
        });

        static::updated(function ($report) {
            $report->updateProductStock();
        });

        static::deleted(function ($report) {
            $report->updateProductStock();
        });
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    /**
     * Update stok produk berdasarkan laporan stok
     */
    public function updateProductStock()
    {
        $product = $this->product;
        if ($product) {
            // Hitung total stok dari semua report
            $totalIn = ReportStock::where('id_product', $this->id_product)
                ->where('type', 'in')
                ->sum('quantity');

            $totalOut = ReportStock::where('id_product', $this->id_product)
                ->where('type', 'out')
                ->sum('quantity');

            $currentStock = $totalIn - $totalOut;

            // Update stok produk
            $product->update(['stok' => max(0, $currentStock)]);
        }
    }

    /**
     * Scope untuk stok masuk
     */
    public function scopeStockIn($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope untuk stok keluar
     */
    public function scopeStockOut($query)
    {
        return $query->where('type', 'out');
    }

    /**
     * Scope untuk tanggal tertentu
     */
    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('movement_date', $date);
    }

    /**
     * Accessor untuk menampilkan quantity dengan tanda
     */
    public function getSignedQuantityAttribute()
    {
        return $this->type === 'in' ? '+' . $this->quantity : '-' . $this->quantity;
    }

    /**
     * Get total stok masuk untuk produk tertentu
     */
    public static function getTotalStockIn($productId)
    {
        return static::where('id_product', $productId)
            ->where('type', 'in')
            ->sum('quantity');
    }

    /**
     * Get total stok keluar untuk produk tertentu
     */
    public static function getTotalStockOut($productId)
    {
        return static::where('id_product', $productId)
            ->where('type', 'out')
            ->sum('quantity');
    }
}