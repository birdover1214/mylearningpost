<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [
        'id'
    ];

    //リレーション作成
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function skill() {
        return $this->belongsTo('App\Models\Skill');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }

    public function talks() {
        return $this->hasMany('App\Models\Talk');
    }
}
