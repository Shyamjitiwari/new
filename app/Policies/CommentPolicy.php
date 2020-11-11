<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any comments.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions->contains('key','read-comments');
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        return $user->role->permissions->contains('key','read-comments') ||
        $user->id == $comment->created_id ||
        $user->id == $comment->updated_id;
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('key','create-comments');
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->role->permissions->contains('key','update-comments') ||
        $user->id == $comment->created_id ||
        $user->id == $comment->updated_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->role->permissions->contains('key','delete-comments') ||
        $user->id == $comment->created_id ||
        $user->id == $comment->updated_id;
    }
}
