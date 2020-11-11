<?php

namespace App;

class Attribute extends App
{
    protected $fillable = [
        'id',
        'name',
        'attribute_group_id',
        'description',
        'sort',
        'status',
        'updated_id',
        'created_id'
    ];    
    public function attribute_group()
    {
        return $this->belongsTo(AttributeGroup::class)
            ->orderBy('sort', 'asc')
            ->orderBy('name', 'asc');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'attributables');
    }

    public function brands()
    {
        return $this->morphedByMany(Brand::class, 'brandables');
    }
}
