<?php

namespace App;

use App\Traits\Common;
use App\Traits\Search;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Search, Common;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categories_created()
    {
        return $this->hasMany(Category::class, 'created_id', 'id')->where('status','active');
    }

    public function tags_created()
    {
        return $this->hasMany(Tag::class, 'created_id', 'id')->where('status','active');
    }

    public function blogs_created()
    {
        return $this->hasMany(Blog::class, 'created_id', 'id')->where('status','active');
    }

    public function comments_created()
    {
        return $this->hasMany(Comment::class, 'created_id', 'id')->where('status','active');
    }

    public function activities_created()
    {
        return $this->hasMany(Activity::class, 'created_id', 'id');
    }

    public function galleries_created()
    {
        return $this->hasMany(Gallery::class, 'created_id', 'id');
    }

    public function enquiries_created()
    {
        return $this->hasMany(Enquiry::class, 'created_id', 'id');
    }

    public function services_created()
    {
        return $this->hasMany(Service::class, 'created_id', 'id');
    }

    public function testimonials_created()
    {
        return $this->hasMany(Testimonial::class, 'created_id', 'id');
    }

    public function sliders_created()
    {
        return $this->hasMany(Slider::class, 'created_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'created_id', 'id');
    }

    public function categories_updated()
    {
        return $this->hasMany(Category::class, 'updated_id', 'id')->where('status','active');
    }

    public function tags_updated()
    {
        return $this->hasMany(Tag::class, 'updated_id', 'id')->where('status','active');
    }

    public function blogs_updated()
    {
        return $this->hasMany(Blog::class, 'updated_id', 'id')->where('status','active');
    }

    public function galleries_updated()
    {
        return $this->hasMany(Gallery::class, 'updated_id', 'id');
    }

    public function enquiries_updated()
    {
        return $this->hasMany(Enquiry::class, 'updated_id', 'id');
    }

    public function comments_updated()
    {
        return $this->hasMany(Comment::class, 'updated_id', 'id');
    }

    public function services_updated()
    {
        return $this->hasMany(Service::class, 'updated_id', 'id');
    }

    public function testimonials_updated()
    {
        return $this->hasMany(Testimonial::class, 'updated_id', 'id');
    }

    public function sliders_updated()
    {
        return $this->hasMany(Slider::class, 'updated_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class)->where('status','active');
    }

    public function isSuperAdmin()
    {
        return $this->role_id == 1;
    }

    public function isAdmin()
    {
        return $this->role_id == 2;
    }



}
