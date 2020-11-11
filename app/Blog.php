<?php

namespace App;

use App\Common\Commentable;
use Carbon\Carbon;

class Blog extends App
{
    use Commentable;
    protected $fillable = [
        'name', 'slug', 'category_id', 'description', 'meta_title', 'meta_keywords',
        'meta_description', 'status', 'updated_id', 'created_id', 'created_at', 'read_time', 'type'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse( $date)->format('d M Y');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id')->where('status','active');
    }
    

    public function image()
    {
        return $this->hasOne(Imagable::class, 'imagable_id', 'id')
            ->with('image')
            ->where('imagable_type',"App\Blog")
            ->where('primary', true);
    }

   
}
