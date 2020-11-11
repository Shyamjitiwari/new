<?php

namespace App;

class Comment extends App
{
    protected $fillable = ['comment', 'parent_id', 'created_id', 'updated_id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent(){
        return $this->belongsTo('App\Comment', 'parent_id', 'id');
    }

    public function children(){
        return $this->hasMany('App\Comment', 'parent_id', 'id');
    }
}
