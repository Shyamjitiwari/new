<?php

namespace App;

class Image extends App
{
    protected $fillable = [
        'id', 'name', 'thumbnail', 'folder', 'status', 'updated_id', 'created_id'
    ];

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'imagable')->where('status','active');
    }

    public function testimonials()
    {
        return $this->morphedByMany(Testimonial::class, 'imagable')->where('status','active');
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'imagable')->where('status','active');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'imagable');
    }

    public function galleries()
    {
        return $this->morphedByMany(Gallery::class, 'imagable');
    }

}
