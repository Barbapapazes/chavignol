<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dislike;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class DislikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        Dislike::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dislike $dislike): Response
    {
        Gate::authorize('delete', $dislike);

        $dislike->delete();

        return response()->noContent();
    }
}
