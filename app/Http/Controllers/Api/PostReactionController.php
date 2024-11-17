<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReactionResource;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostReactionController extends Controller
{
    public function index(Request $request, Post $post): JsonResponse
    {
        // Get the reactions for the post grouped by emoji with the count
        $reactions = DB::table('emoji')
            ->select(
                'emoji.id',
                'emoji.name',
                'emoji.emoji',
                DB::raw('count(reactions.emoji_id) as count')
            )
            ->leftJoin('reactions', function (JoinClause $join) use ($post): void {
                $join->on('emoji.id', '=', 'reactions.emoji_id')
                    // Filter the reactions by the post
                    ->where('reactions.post_id', '=', $post->id);
            })
            ->groupBy('emoji.id')
            ->get();

        return response()->json([
            'data' => $reactions,
        ]);
    }

    public function store(Request $request, Post $post): ReactionResource
    {
        $validatedAttributes = $request->validate([
            'emoji_id' => 'required|exists:emoji,id',
        ]);

        $reaction = $post->reactions()->create([
            'emoji_id' => $validatedAttributes['emoji_id'],
            'user_id' => $request->user()->id,
        ]);

        $reaction->load('emoji');

        return ReactionResource::make($reaction);
    }

    public function destroy(Post $post, Reaction $reaction): Response
    {
        Gate::authorize('delete', $reaction);

        $reaction->delete();

        return response()->noContent();
    }
}
