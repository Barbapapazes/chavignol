<?php

declare(strict_types=1);

use App\Models\Emoji;
use App\Models\Post;
use App\Models\User;

test('requires authentication', function () {
    $this->postJson(route('posts.reactions.store', Post::factory()->create()))
        ->assertUnauthorized();
});

test('stores a reaction for a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $emoji = Emoji::factory()->create();

    $this->actingAs($user)
        ->postJson(route('posts.reactions.store', $post), [
            'emoji_id' => $emoji->id,
        ]);

    $this->assertDatabaseHas('reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'emoji_id' => $emoji->id,
    ]);
});

test('returns the stored reaction', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $emoji = Emoji::factory()->create();

    $response = $this->actingAs($user)
        ->postJson(route('posts.reactions.store', $post), [
            'emoji_id' => $emoji->id,
        ]);

    $response->assertJson([
        'data' => [
            'id' => $response['data']['id'],
            'emoji' => [
                'id' => $emoji->id,
                'name' => $emoji->name,
                'emoji' => $emoji->emoji,
            ],
        ],
    ]);
});

test('returns a status of 201 when a reaction is stored', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $emoji = Emoji::factory()->create();

    $this->actingAs($user)
        ->postJson(route('posts.reactions.store', $post), [
            'emoji_id' => $emoji->id,
        ])
        ->assertCreated();
});

test('requires a valid emoji_id to store a reaction', function (array $badData, array $errors) {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('posts.reactions.store', $post), $badData)
        ->assertJsonValidationErrors($errors);
})
    ->with([
        [['emoji_id' => ''], ['emoji_id' => ['The emoji id field is required.']]],
        [['emoji_id' => 'invalid'], ['emoji_id' => ['The selected emoji id is invalid.']]],
        [['emoji_id' => 0], ['emoji_id' => ['The selected emoji id is invalid.']]],
        [['emoji_id' => 999], ['emoji_id' => ['The selected emoji id is invalid.']]],
    ]);
