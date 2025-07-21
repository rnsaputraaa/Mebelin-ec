<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices';
    protected $primaryKey = 'id_price';

    protected $fillable = [
        'regular_price',
        'price_sale',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'id_price', 'id_price');
    }

    public function getFinalPriceAttribute()
    {
        return $this->price_sale ?? $this->regular_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->price_sale && $this->regular_price > $this->price_sale) {
            return round((($this->regular_price - $this->price_sale) / $this->regular_price) * 100);
        }
        return 0;
    }
}