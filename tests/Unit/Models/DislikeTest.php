<?php

declare(strict_types=1);

use App\Models\Dislike;
use App\Models\User;

test('to array', function () {
    $dislike = Dislike::factory()->create()->fresh();

    expect(array_keys($dislike->toArray()))
        ->toEqual([
            'id',
            'post_id',
            'user_id',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $dislike = Dislike::factory()->create();

    expect($dislike->user)->toBeInstanceOf(User::class);
});
