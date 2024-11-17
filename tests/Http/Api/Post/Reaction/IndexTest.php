<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Testing\Fluent\AssertableJson;

test('returns all emoji for a post', function () {
    $emoji = Emoji::factory()->create();
    $anotherEmoji = Emoji::factory()->create();
    $post = Post::factory()->create();
    $reactions = Reaction::factory()
        ->for($emoji)
        ->for($post)
        ->count(3)
        ->create();

    $this->getJson(route('posts.reactions.index', $post))
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 2)
            ->where('data.0.id', $emoji->id)
            ->where('data.0.name', $emoji->name)
            ->where('data.0.emoji', $emoji->emoji)
            ->where('data.0.count', 3)
            ->where('data.1.id', $anotherEmoji->id)
            ->where('data.1.name', $anotherEmoji->name)
            ->where('data.1.emoji', $anotherEmoji->emoji)
            ->where('data.1.count', 0)
        );
});
