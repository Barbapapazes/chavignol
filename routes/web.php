<?php

declare(strict_types=1);

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->redirectToRoute('posts.index'))->name('home');

Route::get('posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
