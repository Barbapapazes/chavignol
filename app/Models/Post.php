<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    /**
     * Get the reactions that belong to the post.
     *
     * @return HasMany<Reaction, covariant $this>
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    /**
     * Get the comments that belong to the post.
     *
     * @return HasMany<Comment, covariant $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
