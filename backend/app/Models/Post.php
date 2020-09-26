<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'skill_id', 'time', 'title', 'comment'
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
}
