<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Testing\Fluent\AssertableJson;

test('returns all comments for a post', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory()
        ->for($post)
        ->count(3)
        ->create();

    $this->getJson(route('posts.comments.index', $post))
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 3)
            ->where('data.0.id', $comments[0]->id)
            ->where('data.0.content', $comments[0]->content)
            ->where('data.0.user.id', $comments[0]->user->id)
            ->where('data.0.user.name', $comments[0]->user->name)
            ->where('data.1.id', $comments[1]->id)
            ->where('data.1.content', $comments[1]->content)
            ->where('data.1.user.id', $comments[1]->user->id)
            ->where('data.1.user.name', $comments[1]->user->name)
            ->where('data.2.id', $comments[2]->id)
            ->where('data.2.content', $comments[2]->content)
            ->where('data.2.user.id', $comments[2]->user->id)
            ->where('data.2.user.name', $comments[2]->user->name)
        );
});
