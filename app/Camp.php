<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    protected $fillable = [
        'name', 'bg_color', 'camp_limit', 'starts_at', 'ends_at', 'location_id', 'is_deleted', 	'hd', 'fd',
        'fhd', 'ffd', 'hd_p_id', 'fd_p_id', 'fhd_hd_p_id', 'fhd_fd_p_id', 'ffd_hd_p_id', 'ffd_fd_p_id',
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'hd' => 'int',
        'fd' => 'int',
        'fhd' => 'int',
        'ffd' => 'int',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function taskclasses()
    {
        return $this->hasMany(TaskClass::class);
    }

    public function timezones()
    {
        return $this->belongsToMany('App\Timezone');
    }
}
