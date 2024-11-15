<?php

declare(strict_types=1);

use App\Models\Like;
use App\Models\User;

test('to array', function () {
    $like = Like::factory()->create()->fresh();

    expect(array_keys($like->toArray()))
        ->toEqual([
            'id',
            'post_id',
            'user_id',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $like = Like::factory()->create();

    expect($like->user)->toBeInstanceOf(User::class);
});
