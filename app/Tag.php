<?php

namespace App;

class Tag extends App
{
    protected $fillable = [
        'id', 'name', 'slug', 'type', 'description', 'meta_title', 'meta_keywords',
        'meta_description', 'status', 'updated_id', 'created_id'
    ];

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'taggable')->where('status','active');
    }
    public function services()
    {
        return $this->morphedByMany(Service::class, 'taggable')->where('status','active');
    }
}
