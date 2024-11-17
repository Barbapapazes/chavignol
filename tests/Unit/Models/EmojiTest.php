<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Reaction;

test('to array', function () {
    $emoji = Emoji::factory()->create()->fresh();

    expect(array_keys($emoji->toArray()))
        ->toEqual([
            'id',
            'name',
            'emoji',
            'created_at',
            'updated_at',
        ]);
});

test('relations', function () {
    $emoji = Emoji::factory()
        ->hasReactions(1)
        ->create();

    expect($emoji->reactions)->each->toBeInstanceOf(Reaction::class);
});
