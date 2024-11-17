<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('requires authentication', function () {
    $this->postJson(route('posts.comments.store', Post::factory()->create()))
        ->assertUnauthorized();
});

test('creates a comment for a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $content = 'This is a comment.';

    $this->actingAs($user)
        ->postJson(route('posts.comments.store', $post), [
            'content' => $content,
        ]);

    $this->assertDatabaseHas('comments', [
        'content' => $content,
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);
});

test('returns the created comment', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $content = 'This is a comment.';

    $this->actingAs($user)
        ->postJson(route('posts.comments.store', $post), [
            'content' => $content,
        ])->assertJson(fn (AssertableJson $json) => $json
        ->where('data.content', $content)
        ->where('data.user.id', $user->id)
        ->where('data.user.name', $user->name)
        );
});

test('returns a status code of 201 when a comment is created', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $content = 'This is a comment.';

    $this->actingAs($user)
        ->postJson(route('posts.comments.store', $post), [
            'content' => $content,
        ])->assertCreated();
});

test('requires a valid content to store a comment', function (array $badData, array $errors) {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson(route('posts.comments.store', $post), $badData);

    $response->assertJsonValidationErrors($errors);
})->with([
    [['content' => ''], ['content' => 'The content field is required.']],
    [['content' => str_repeat('a', 256)], ['content' => 'The content field must not be greater than 255 characters.']],
]);
