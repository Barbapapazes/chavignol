<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emoji extends Model
{
    /** @use HasFactory<\Database\Factories\EmojiFactory> */
    use HasFactory;

    /**
     * Get the reactions that belong to the emoji.
     *
     * @return HasMany<Reaction, covariant $this>
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }
}
