<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Dislike;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DislikePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dislike $dislike): Response
    {
        return $user->id === $dislike->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
