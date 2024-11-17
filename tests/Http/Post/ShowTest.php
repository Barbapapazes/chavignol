<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

test('displays a post', function () {
    $post = Post::factory()->create([
        'slug' => 'the-simplest-method-to-create-a-vue-js-component-library',
    ]);

    // Act: Make a GET request to the show route
    $this->get(route('posts.show', $post))
        ->assertViewIs('posts.show')
        ->assertViewHas('html', Str::markdown(File::get(resource_path('markdown/posts/'.$post->slug.'.md'))));
});

test('returns a 404 when a post does not exist', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.show', ['post' => $post->id + 1]))
        ->assertNotFound();
});

test('returns a 404 when the related markdown file does not exist', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.show', $post))
        ->assertNotFound();
});
