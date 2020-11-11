<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskClassType extends Model
{
    protected $table = 'task_class_types';
    
    protected $fillable = [
        'type_name','send_reminder'
    ];

    public function taskclasses()
    {
        return $this->hasMany(TaskClass::class);
    }

    public function stripes()
    {
        return $this->hasMany('App\Stripe');
    }
}
