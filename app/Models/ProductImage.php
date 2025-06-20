<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    protected $primaryKey = 'id_product_images';

    protected $fillable = [
        'product_id',
        'url_gambar',
        'first_picture',
        'sort',
    ];

    protected $casts = [
        'first_picture' => 'boolean',
    ];

    /**
     * Boot method untuk auto-delete file
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-delete file saat record dihapus
        static::deleting(function ($image) {
            if ($image->url_gambar && Storage::disk('public')->exists($image->url_gambar)) {
                Storage::disk('public')->delete($image->url_gambar);
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    /**
     * Get full URL untuk gambar
     */
    public function getImageUrlAttribute()
    {
        if (!$this->url_gambar) {
            return null;
        }
        return asset('storage/' . $this->url_gambar);
    }

    /**
     * Check if image file exists
     */
    public function getImageExistsAttribute()
    {
        if (!$this->url_gambar) {
            return false;
        }
        return Storage::disk('public')->exists($this->url_gambar);
    }

    /**
     * Get file size in bytes
     */
    public function getFileSizeAttribute()
    {
        if (!$this->url_gambar || !$this->image_exists) {
            return 0;
        }
        return Storage::disk('public')->size($this->url_gambar);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope untuk gambar utama
     */
    public function scopeMainImage($query)
    {
        return $query->where('first_picture', true);
    }

    /**
     * Scope untuk urutkan berdasarkan sort dan created_at
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort')->orderBy('created_at');
    }

    /**
     * Scope untuk default order yang digunakan di admin
     */
    public function scopeDefaultOrder($query)
    {
        return $query->orderBy('product_id', 'asc')
                    ->orderBy('sort', 'asc')
                    ->orderBy('created_at', 'desc');
    }
}