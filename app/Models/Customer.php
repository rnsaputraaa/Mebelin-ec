<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'no_telepon',
        'tanggal_lahir',
        'profil_picture',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class, 'id_customer', 'id_customer');
    }

    // Mendapatkan alamat utama customer
    public function primaryAddress()
    {
        return $this->hasOne(CustomerAddress::class, 'id_customer', 'id_customer')
                    ->where('alamat_utama', true);
    }

    // Mendapatkan alamat tambahan (bukan utama)
    public function secondaryAddresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class, 'id_customer', 'id_customer')
                    ->where('alamat_utama', false);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id_customer');
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'id_customer', 'id_customer');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id', 'id_customer');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Content::class, 'id_customer', 'id_customer');
    }

    // Accessor untuk mendapatkan alamat lengkap utama
    public function getPrimaryAddressTextAttribute(): string
    {
        $primaryAddress = $this->primaryAddress;
        
        if (!$primaryAddress) {
            return 'Belum ada alamat utama';
        }

        return $primaryAddress->alamat_lengkap . ', ' . 
               $primaryAddress->kota . ', ' . 
               $primaryAddress->provinsi . ' ' . 
               $primaryAddress->kode_pos;
    }

    // Method untuk menghitung total alamat
    public function getTotalAddressesAttribute(): int
    {
        return $this->addresses()->count();
    }

    // Method untuk cek apakah customer memiliki alamat utama
    public function hasPrimaryAddress(): bool
    {
        return $this->addresses()->where('alamat_utama', true)->exists();
    }

    // Method untuk set alamat sebagai utama
    public function setPrimaryAddress(int $addressId): bool
    {
        // Set semua alamat menjadi tidak utama
        $this->addresses()->update(['alamat_utama' => false]);
        
        // Set alamat yang dipilih menjadi utama
        return $this->addresses()
                    ->where('id_customer_addresses', $addressId)
                    ->update(['alamat_utama' => true]) > 0;
    }
}