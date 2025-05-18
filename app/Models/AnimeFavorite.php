<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimeFavorite extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'anime_id',
        'anime_title',
        'image_url',
        'description',
    ];

    /**
     * Récupérer l'utilisateur auquel appartient ce favori
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}