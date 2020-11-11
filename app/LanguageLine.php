<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageLine extends Model
{
    protected $table = 'language_lines';

     /** @var array */
     public $translatable = ['text'];

     /** @var array */
     public $guarded = ['id'];
 
     /** @var array */
     protected $casts = ['text' => 'array'];
}

