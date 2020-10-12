<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'user_image', 'created_at', 'updated_at'
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


    //リレーション作成
    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function talks() {
        return $this->hasMany('App\Models\Talk');
    }

    public function favorites() {
        return $this->belongsToMany('App\Models\Post')->withTimestamps();
    }

    public function skills() {
        return $this->belongsToMany('App\Models\Skill')->withTimestamps();
    }
}
