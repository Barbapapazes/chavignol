<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

test('requires authentication', function () {
    $this->deleteJson(route('posts.reactions.destroy', [Post::factory()->create(), Reaction::factory()->create()]))
        ->assertUnauthorized();
});

test('destroys a reaction for a post', function () {
    $post = Post::factory()->create();
    $emoji = Emoji::factory()->create();
    $user = User::factory()->create();
    $reaction = Reaction::factory()
        ->for($emoji)
        ->for($post)
        ->for($user)
        ->create();

    $this->actingAs($user)
        ->deleteJson(route('posts.reactions.destroy', [$post, $reaction]));

    $this->assertDatabaseMissing('reactions', [
        'id' => $reaction->id,
    ]);
});

test('requires the user to be the owner of the reaction', function () {
    $post = Post::factory()->create();
    $emoji = Emoji::factory()->create();
    $user = User::factory()->create();
    $reaction = Reaction::factory()
        ->for($emoji)
        ->for($post)
        ->for($user)
        ->create();

    $anotherUser = User::factory()->create();

    $this->actingAs($anotherUser)
        ->deleteJson(route('posts.reactions.destroy', [$post, $reaction]))
        ->assertNotFound();
});

test('returns no content when a reaction is destroyed', function () {
    $post = Post::factory()->create();
    $emoji = Emoji::factory()->create();
    $user = User::factory()->create();
    $reaction = Reaction::factory()
        ->for($post)
        ->for($user)
        ->for($emoji)
        ->create();

    $this->actingAs($user)
        ->deleteJson(route('posts.reactions.destroy', [$post, $reaction]))
        ->assertNoContent();
});
