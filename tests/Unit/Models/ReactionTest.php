<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

test('to array', function () {
    $reaction = Reaction::factory()->create()->fresh();

    expect(array_keys($reaction->toArray()))
        ->toEqual([
            'id',
            'user_id',
            'post_id',
            'emoji_id',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $reaction = Reaction::factory()
        ->hasUser(1)
        ->hasPost(1)
        ->hasEmoji(1)
        ->create();

    expect($reaction->user)->toBeInstanceOf(User::class)
        ->and($reaction->post)->toBeInstanceOf(Post::class)
        ->and($reaction->emoji)->toBeInstanceOf(Emoji::class);
});
