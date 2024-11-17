<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReactionPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reaction $reaction): Response
    {
        return $user->id === $reaction->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
