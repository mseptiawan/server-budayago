<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'culture_id',
    ];

    /**
     * Relasi: favorit ini dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: favorit ini terkait dengan satu budaya.
     */
    public function culture(): BelongsTo
    {
        return $this->belongsTo(Culture::class);
    }
}
