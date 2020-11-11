<?php

namespace App;

class Product extends App
{
    protected $fillable = [
        'name', 'slug', 'category_id','brand_id', 'description', 'meta_title', 'meta_keywords',
        'meta_description', 'status', 'updated_id', 'created_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }


    public function image()
    {
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Product")
            ->where('primary', true);
    }
}
