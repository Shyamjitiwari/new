<?php

namespace App\Common;

trait Commentable {

    //returs only active comments
	public function activeComments()
    {
        return $this->morphMany(\App\Comment::class,'commentable')->where([['status','active'],['parent_id', NULL]]);
    }

    ////returs all comments
    public function comments()
    {
        return $this->morphMany(\App\Comment::class,'commentable')->where('parent_id',NULL);
    }
}