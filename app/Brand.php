<?php

namespace App;

class Brand extends App
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description', 
        'status', 
        'updated_id', 
        'created_id', 
        'created_at', 
        'updated_at'
    ];
    public function image()
    {
 
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Brand")
            ->where('primary', true);
    }

    public function products()
    {
        return $this->hasMany(Brand::class);
    }
}
