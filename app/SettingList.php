<?php

namespace App;

class SettingList extends App
{
    public function setting(){
        return $this->belongsTo('App\Setting', 'setting_key', 'key');
    }
}
