<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreezedSubscriptions extends Model
{
    protected $table = 'freezed_subscriptions';
    protected $fillable = [
        'user_id','subscription_id','reason_of_freezing'
    ];

}
