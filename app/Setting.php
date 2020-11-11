<?php

namespace App;

class Setting extends App
{
    protected $fillable = ['value'];

    public function updated_by(){
        return $this->belongsTo('App\User', 'updated_id','id');
    }

    public function lists(){
        return $this->hasMany('App\SettingList', 'setting_key', 'key');
    }
}
