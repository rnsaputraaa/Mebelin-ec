<?php

// SOLUSI 1: Tambahkan method getFilamentName() ke Model User
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

   protected $fillable = [
        'id_user',          
        'nama_lengkap',
        'password',
        "u_type",
        'email',
        'no_telepon',
        'tanggal_lahir',
        'profil_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified' => 'datetime',
        'password' => 'hashed',
    ];

    // SOLUSI UTAMA: Method untuk Filament getUserName
    public function getFilamentName(): string
    {
        // Prioritas: username -> email -> 'User'
        return $this->username 
            ?? explode('@', $this->email)[0] 
            ?? 'User';
    }

    // Alternative method jika getFilamentName tidak work
    public function getName(): string
    {
        return $this->getFilamentName();
    }

    // Atau override getNameAttribute
    public function getNameAttribute(): string
    {
        return $this->username 
            ?? explode('@', $this->email)[0] 
            ?? 'User';
    }

    // Method untuk Filament authentication
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->u_type === 'admin';
    }

    // Override method getAuthIdentifierName untuk primary key custom
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    // Method untuk generate username otomatis jika kosong
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->username)) {
                // Generate username dari email
                $baseUsername = explode('@', $user->email)[0];
                $user->username = $baseUsername;
                
                // Pastikan username unique
                $counter = 1;
                while (static::where('username', $user->username)->exists()) {
                    $user->username = $baseUsername . $counter;
                    $counter++;
                }
            }
        });
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id_user', 'id_user');
    }
}