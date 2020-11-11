<?php

namespace App;

class Menu extends App
{
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function parent()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
            ->where('parent_id', null);
    }

    public function child()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id')
            ->where('parent_id', '!=', null);
    }
}
