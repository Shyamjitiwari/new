<?php

namespace App;

class Page extends App
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title', 
        'meta_keywords',
        'meta_description',
        'status',
        'created_id',
        'updated_id'
     ];
    public function image()
    {
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Page")
            ->where('primary', true);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
