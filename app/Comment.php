<?php

namespace App;

use Carbon\Carbon;

class Comment extends App
{

    protected $fillable = [
       'description',
       'status',
       'parent_id',
       'created_id',
       'name',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne(User::class)->where('status','active');
    }


    public function parent(){
        return $this->belongsTo('App\Comment', 'parent_id', 'id')->withCount('replies')->where([['parent_id',NULL],['status','active']]);
    }
    public function allReplies()
    {
        return $this->hasMany('App\Comment', 'parent_id', 'id')->orderBy('created_at', 'desc')->where('parent_id','!=',NULL);
    }
    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id', 'id')->orderBy('created_at', 'desc')->where([['parent_id','!=',NULL],['status','active']]);
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse( $date)->toDateTimeString();
    }





}
