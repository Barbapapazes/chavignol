<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LikePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Like $like): Response
    {
        return $user->id === $like->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
