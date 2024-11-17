<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReactionResource;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserPostReactionController extends Controller
{
    public function index(Request $request, Post $post): AnonymousResourceCollection
    {
        $reactions = Reaction::query()
            ->whereBelongsTo($request->user())
            ->whereBelongsTo($post)
            ->with('emoji')
            ->get();

        return ReactionResource::collection($reactions);
    }
}
