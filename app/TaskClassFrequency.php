<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskClassFrequency extends Model
{ 
    protected $table = 'task_class_frequencies';
    protected $fillable = [
        'name',
    ];
}
