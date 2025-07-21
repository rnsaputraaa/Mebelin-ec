<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'product_name',
        'slug',
        'description',
        'stok',
        'stok_sales',
        'size',
        'view',
        'id_product_variant',
        'id_category',
    ];

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->product_name)) {
                $product->slug = static::generateUniqueSlug($product->product_name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('product_name') && empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->product_name);
            }
        });
    }

    /**
     * Generate slug unik
     */
    public static function generateUniqueSlug(string $productName, $excludeId = null): string
    {
        $baseSlug = Str::slug($productName);
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id_product', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id_product', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_product', 'id_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id_product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_product', 'id_product');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id_product', 'id_product');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id_product');
    }

    public function comments()
    {
        return $this->hasMany(Content::class, 'id_product', 'id_product');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->where('first_picture', true)->first();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}