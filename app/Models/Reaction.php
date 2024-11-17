<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    /** @use HasFactory<\Database\Factories\ReactionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'emoji_id',
        'user_id',
        'post_id',
    ];

    /**
     * Get the post that the reaction belongs to.
     *
     * @return BelongsTo<Post, covariant $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that the reaction belongs to.
     *
     * @return BelongsTo<User, covariant $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the emoji that the reaction belongs to.
     *
     * @return BelongsTo<Emoji, covariant $this>
     */
    public function emoji(): BelongsTo
    {
        return $this->belongsTo(Emoji::class);
    }
}
