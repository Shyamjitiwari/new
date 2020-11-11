<?php

namespace App;

class Slider extends App
{
    protected $fillable = [
        'heading',
        'hyper_link',
        'description_line1',
        'description_line2',
        'description_line3',
        'status',
        'created_id',
        'updated_id' 
    ];

    public function image()
    {
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Slider")
            ->where('primary', true);
    }
}
