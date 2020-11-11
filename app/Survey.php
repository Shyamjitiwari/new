<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $fillable = [
        'user_id', 'rate','improvement','valuable_part_of_cwu', 'update_id', 'student_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id', 'id');
    }

    public function updateModel()
    {
        return $this->belongsTo('App\Update', 'update_id', 'id');
    }
}
