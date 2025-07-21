<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    protected $primaryKey = 'id_product_variant';

    protected $fillable = [
        'id_product',
        'color', 
        'id_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'id_price', 'id_price');
    }
}