<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('requires authentication', function () {
    $this->getJson(route('user.posts.reactions.index', Post::factory()->create()))
        ->assertUnauthorized();
});

test('returns reactions for a post', function () {
    $emoji = Emoji::factory()->create();
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $reactions = Reaction::factory()
        ->for($emoji)
        ->for($post)
        ->for($user)
        ->create();

    $this->actingAs($user)
        ->getJson(route('user.posts.reactions.index', $post))
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 1, fn (AssertableJson $json) => $json
                ->where('id', $reactions->first()->id)
                ->where('emoji.id', $emoji->id)
                ->where('emoji.name', $emoji->name)
                ->where('emoji.emoji', $emoji->emoji)
            )
        );
});
