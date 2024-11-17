<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('requires authentication', function () {
    $this->deleteJson(route('posts.comments.destroy', [Post::factory()->create(), Comment::factory()->create()]))
        ->assertUnauthorized();
});

test('destroys a comment for a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $comment = Comment::factory()
        ->for($post)
        ->for($user)
        ->create();

    $this->actingAs($user)
        ->deleteJson(route('posts.comments.destroy', [$post, $comment]));

    $this->assertDatabaseMissing('comments', [
        'id' => $comment->id,
    ]);
});

test('requires the user to be the owner of the comment', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $comment = Comment::factory()
        ->for($post)
        ->for($user)
        ->create();

    $anotherUser = User::factory()->create();

    $this->actingAs($anotherUser)
        ->deleteJson(route('posts.comments.destroy', [$post, $comment]))
        ->assertNotFound();
});

test('returns no content when a comment is destroyed', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();
    $comment = Comment::factory()
        ->for($post)
        ->for($user)
        ->create();

    $this->actingAs($user)
        ->deleteJson(route('posts.comments.destroy', [$post, $comment]))
        ->assertNoContent();
});
