<?php

namespace App;

class Reply extends App
{
    protected $table = 'comments';

    protected $fillable = [
       'description',
       'status',
       'parent_id',
       'created_id',
       'user_name',
    ];

}
