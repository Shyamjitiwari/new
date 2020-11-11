<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $fillable = [
        'name',
    ];
    
    public function timezones()
    {
        return $this->hasMany('App\Timezone');
    }
}
