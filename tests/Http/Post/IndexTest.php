<?php

declare(strict_types=1);

use App\Models\Post;

test('displays posts', function () {
    $posts = Post::factory()->count(3)
        ->sequence(
            ['created_at' => now()->subDays(2)],
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        )
        ->create();

    $this->get(route('posts.index'))
        ->assertStatus(200)
        ->assertViewIs('posts.index')
        ->assertViewHas('posts', Post::latest()->get());
});
