<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PostCommentController extends Controller
{
    public function index(Post $post): AnonymousResourceCollection
    {
        $comments = $post->comments()
            ->with('user')
            ->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request, Post $post): CommentResource
    {
        $validatedAttributes = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = $post->comments()->create([
            'content' => $validatedAttributes['content'],
            'user_id' => $request->user()->id,
        ]);

        $comment->load('user');

        return CommentResource::make($comment);
    }

    public function destroy(Post $post, Comment $comment): Response
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->noContent();
    }
}
