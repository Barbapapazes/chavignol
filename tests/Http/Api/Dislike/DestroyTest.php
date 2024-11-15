<?php

declare(strict_types=1);

use App\Models\Dislike;
use App\Models\User;

it('requires authentification', function () {
    $this->deleteJson(route('api.dislikes.destroy', Dislike::factory()->create()))
        ->assertUnauthorized();
});

it('destroys a dislike', function () {
    $user = User::factory()->create();
    $dislike = Dislike::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.dislikes.destroy', $dislike));

    $this->assertDatabaseMissing('dislikes', [
        'user_id' => $user->id,
    ]);
});

it('send no content', function () {
    $user = User::factory()->create();
    $dislike = Dislike::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.dislikes.destroy', $dislike))
        ->assertNoContent();
});

it('cannot destroy a dislike twice', function () {
    $user = User::factory()->create();
    $dislike = Dislike::factory()->for($user)->create();

    $this->actingAs($user)
        ->deleteJson(route('api.dislikes.destroy', $dislike));

    $this->actingAs($user)
        ->deleteJson(route('api.dislikes.destroy', $dislike))
        ->assertNotFound();

    $this->assertDatabaseCount('dislikes', 0);
});

it('cannot destroy a dislike from another user', function () {
    $user = User::factory()->create();
    $dislike = Dislike::factory()->create();

    $this->actingAs($user)
        ->deleteJson(route('api.dislikes.destroy', $dislike))
        ->assertNotFound();

    $this->assertDatabaseCount('dislikes', 1);
});
