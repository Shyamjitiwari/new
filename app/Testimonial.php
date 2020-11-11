<?php

namespace App;

class Testimonial extends App
{
    protected $fillable = [
        'id', 
        'name',
        'company',
        'designation',
        'description', 
        'status',
        'updated_id',
        'created_id'
    ];

    public function image()
    {
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Testimonial")
            ->where('primary', true);
    }
}
