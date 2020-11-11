<?php

namespace App;

class SettingList extends App
{
    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id','id');
    }

    public function setting(){
        return $this->belongsTo('App\Setting', 'setting_key', 'key');
    }

}
