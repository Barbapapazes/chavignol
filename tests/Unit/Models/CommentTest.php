<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('to array', function () {
    $comment = Comment::factory()->create()->fresh();

    expect(array_keys($comment->toArray()))
        ->toEqual([
            'id',
            'user_id',
            'post_id',
            'content',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $comment = Comment::factory()
        ->hasUser(1)
        ->hasPost(1)
        ->create();

    expect($comment->user)->toBeInstanceOf(User::class)
        ->and($comment->post)->toBeInstanceOf(Post::class);
});
