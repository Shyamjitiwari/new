<?php

namespace App\Traits;

use App\Activity;
use App\Attribute;
use App\Brand;
use App\Image;
use App\Tag;
use Carbon\Carbon;

trait Common
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse( $date)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse( $date)->format('d-m-Y');
    }

    public function created_by(){
        return $this->belongsTo('App\User', 'created_id', 'id');
    }

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id', 'id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributables')
            ->withPivot('value');
    }

    // public function brands()
    // {
    //     return $this->morphToMany(Brand::class, 'brandables');
    // }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imagable')
            ->withPivot('alt', 'meta_title', 'meta_description', 'meta_keywords', 'primary');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activity');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status','active');
    }
}
