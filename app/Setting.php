<?php

namespace App;

class Setting extends App
{
    protected $fillable = ['value'];

    public function lists(){
        return $this->hasMany('App\SettingList', 'setting_key', 'key');
    }
}
