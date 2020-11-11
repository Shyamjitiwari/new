<?php

namespace App;

class Imagable extends App
{
    protected $table = 'imagables';

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Blog')
            ->where('primary', true)
            ->where('status','active');
    }

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Testimonial')
            ->where('primary', true)
            ->where('status','active');
    }

    public function slider()
    {
        return $this->belongsTo(Slider::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Slider')
            ->where('primary', true);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Service')
            ->where('primary', true);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Product')
            ->where('primary', true);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'imagable_id', 'id')
            ->where('imagable_type','App\Brand')
            ->where('primary', true);
    }
}
