<?php

declare(strict_types=1);

use App\Models\User;

it('requires authentication', function () {
    $this->postJson(route('api.dislikes.store'))
        ->assertUnauthorized();
});

it('stores a dislike', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.dislikes.store'));

    $this->assertDatabaseHas('dislikes', [
        'user_id' => $user->id,
    ]);
});

it('send no content', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.dislikes.store'))
        ->assertNoContent();
});

it('cannot store a dislike twice', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.dislikes.store'));

    $this->actingAs($user)
        ->postJson(route('api.dislikes.store'))
        ->assertNoContent();

    $this->assertDatabaseCount('dislikes', 1);
});
