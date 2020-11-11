<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table = 'references';
    protected $fillable = [
        'reference_hash', 'email','country_id','phone_number', 'referred_by', 
        'referred_to', 'signup_for_camp','signup_for_free_session'
    ];

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    public function referredTo()
    {
        return $this->belongsTo(User::class, 'referred_to', 'id');
    }
}
