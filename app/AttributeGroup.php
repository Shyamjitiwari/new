<?php

namespace App;

class AttributeGroup extends App
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'sort',
        'status',
        'updated_id',
        'created_id'
    ]; 
    public function attributes()
    {
        return $this->hasMany(Attribute::class)
            ->orderBy('sort', 'asc')
            ->orderBy('name', 'asc');;
    }
}
