<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;

test('to array', function () {
    $post = Post::factory()->create()->fresh();

    expect(array_keys($post->toArray()))
        ->toEqual([
            'id',
            'title',
            'slug',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $post = Post::factory()
        ->hasComments(1)
        ->hasReactions(1)
        ->create();

    expect($post->comments)->each->toBeInstanceOf(Comment::class)
        ->and($post->reactions)->each->toBeInstanceOf(Reaction::class);
});
