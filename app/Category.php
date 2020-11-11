<?php

namespace App;

class Category extends App
{
    protected $fillable = [
        'id', 'name', 'slug', 'type', 'description', 'meta_title', 'meta_keywords',
        'meta_description', 'status', 'updated_id', 'created_id'
    ];

    public function blogs()
    {
        return $this->hasMany('App\Blog')->where('status','active');
    }

    public function products()
    {
        return $this->hasMany('App\Blog');
    }

    public function gallery()
    {
        return $this->hasOne('App\Gallery');
    }
}
