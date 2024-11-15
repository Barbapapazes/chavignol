<?php

declare(strict_types=1);

use App\Models\User;

it('requires authentication', function () {
    $this->postJson(route('api.likes.store'))
        ->assertUnauthorized();
});

it('stores a like', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.likes.store'));

    $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
    ]);
});

it('send no content', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.likes.store'))
        ->assertNoContent();
});

it('cannot store a like twice', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.likes.store'));

    $this->actingAs($user)
        ->postJson(route('api.likes.store'))
        ->assertNoContent();

    $this->assertDatabaseCount('likes', 1);
});
