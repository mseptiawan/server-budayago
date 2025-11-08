<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi (JSON response).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: satu user (admin) dapat memposting banyak budaya.
     */
    public function cultures()
    {
        return $this->hasMany(Culture::class);
    }

    /**
     * Relasi: satu user dapat memiliki banyak favorit.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Helper: cek apakah user adalah admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
