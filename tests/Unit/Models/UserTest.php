<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Reaction;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))
        ->toEqual([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $user = User::factory()
        ->hasReactions(1)
        ->hasComments(1)
        ->create();

    expect($user->reactions)->each->toBeInstanceOf(Reaction::class)
        ->and($user->comments)->each->toBeInstanceOf(Comment::class);
});
