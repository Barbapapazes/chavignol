<?php

declare(strict_types=1);

use App\Http\Controllers\Api\PostCommentController;
use App\Http\Controllers\Api\PostReactionController;
use App\Http\Controllers\Api\UserPostReactionController;
use Illuminate\Support\Facades\Route;

Route::get('posts/{post}/reactions', [PostReactionController::class, 'index'])
    ->name('posts.reactions.index');

Route::get('posts/{post}/comments', [PostCommentController::class, 'index'])
    ->name('posts.comments.index');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/posts/{post}/reactions', [UserPostReactionController::class, 'index'])
        ->name('user.posts.reactions.index');

    Route::post('posts/{post}/reactions', [PostReactionController::class, 'store'])
        ->name('posts.reactions.store');
    Route::delete('posts/{post}/reactions/{reaction}', [PostReactionController::class, 'destroy'])
        ->name('posts.reactions.destroy');

    Route::post('posts/{post}/comments', [PostCommentController::class, 'store'])
        ->name('posts.comments.store');
    Route::delete('posts/{post}/comments/{comment}', [PostCommentController::class, 'destroy'])
        ->name('posts.comments.destroy');
});
