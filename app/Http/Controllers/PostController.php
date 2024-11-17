<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::latest()->get(),
        ]);
    }

    public function show(Post $post): View
    {
        $path = resource_path('markdown/posts/'.$post->slug.'.md');

        $content = File::exists($path)
            ? Str::markdown(File::get($path))
            : null;

        if ($content === null) {
            abort(404);
        }

        return view('posts.show', [
            'html' => $content,
        ]);
    }
}
