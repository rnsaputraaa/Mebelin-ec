<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_addresses';
    protected $primaryKey = 'id_customer_addresses';

    protected $fillable = [
        'id_customer',
        'alamat_lengkap',
        'kota',
        'provinsi',
        'kode_pos',
        'alamat_utama',
        'patokan',
    ];

    protected $casts = [
        'alamat_utama' => 'boolean',
    ];


    public function customer()
{
    return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
}
}

