<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = 'timezones';
    protected $fillable = [
        'country_code','country_name', 'time_zone', 'gmt_offset','locale_id'
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale_id', 'id');
    }

    public function camps()
    {
        return $this->belongsToMany('App\Camp');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
}
