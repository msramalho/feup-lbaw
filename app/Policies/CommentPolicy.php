<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }
    
    /**
     * Determine whether the user can delete comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return ($user->id === $comment->author_id || $user->isAdmin());
    }

    /**
     * Determine whether the user can edit comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id;
    }
}
