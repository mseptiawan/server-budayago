<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Culture extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'province',
        'city_or_regency',
        'short_description',
        'long_description',
        'image_url',
        'video_url',
        'virtual_tour_url',
        'user_id',
    ];

    /**
     * Relasi: budaya dimiliki oleh satu admin (user).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: budaya bisa difavoritkan oleh banyak user.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
