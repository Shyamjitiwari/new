<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table = 'locales';

    public function timezones()
    {
        return $this->hasMany('App\Timezone');
    }
}
