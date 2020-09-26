<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skill_name'
    ];

    //リレーション作成
    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
