<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stripe extends Model
{
    protected $table = 'stripes';
    protected $fillable = [
        'product_id', 'product_name', 'price', 'currency','number_of_credits', 'is_subscription'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function task_class_type()
    {
        return $this->belongsTo('App\TaskClassType');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}

