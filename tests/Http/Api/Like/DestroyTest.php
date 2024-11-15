<?php

declare(strict_types=1);

use App\Models\Like;
use App\Models\User;

it('requires authentification', function () {
    $this->deleteJson(route('api.likes.destroy', Like::factory()->create()))
        ->assertUnauthorized();
});

it('destroys a like', function () {
    $user = User::factory()->create();
    $like = Like::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.likes.destroy', $like));

    $this->assertDatabaseMissing('likes', [
        'user_id' => $user->id,
    ]);
});

it('send no content', function () {
    $user = User::factory()->create();
    $like = Like::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.likes.destroy', $like))
        ->assertNoContent();
});

it('cannot destroy a like twice', function () {
    $user = User::factory()->create();
    $like = Like::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.likes.destroy', $like));

    $this->actingAs($user)
        ->deleteJson(route('api.likes.destroy', $like))
        ->assertNotFound();

    $this->assertDatabaseCount('likes', 0);
});

it('cannot destroy a like from another user', function () {
    $user = User::factory()->create();
    $like = Like::factory()->create();

    $this->actingAs($user)
        ->deleteJson(route('api.likes.destroy', $like))
        ->assertNotFound();

    $this->assertDatabaseCount('likes', 1);
});
