<?php

declare(strict_types=1);

use App\Http\Controllers\Api\DislikeController;
use App\Http\Controllers\Api\LikeController;
use Illuminate\Support\Facades\Route;

Route::post('/likes', [LikeController::class, 'store'])
    ->middleware('auth:sanctum')
    ->name('api.likes.store');

Route::delete('/likes/{like}', [LikeController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('api.likes.destroy');

Route::post('/dislikes', [DislikeController::class, 'store'])
    ->middleware('auth:sanctum')
    ->name('api.dislikes.store');

Route::delete('/dislikes/{dislike}', [DislikeController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('api.dislikes.destroy');
